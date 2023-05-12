<?php

namespace App\Http\Controllers;

use App\Order;
use App\Lab;
use App\Rider;
use App\Reason;
use App\User;
use App\Pack;
use Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderInfoTemplateExport;
use App\Imports\OrderImport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //code...
        $userId = auth()->user()->id;
        $orders = Order::with(['user' => function ($query) {
            $query->withTrashed();
        }])->orderBy('created_at', 'desc')->paginate(20);
        $myOrders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(20);
        return view('pages.order.all_order', compact(['orders', $orders, 'myOrders', $myOrders]));
    }

    /**
     * List all incomplete orders
     */
    public function incompleteOrders()
    {
        try {
            //code...
            $notCompleted = 0;
            $notAssigned = 0;
            $incompleteOrders = Order::with(['user' => function ($query) {
                $query->withTrashed();
            }])->where([['is_assigned', $notAssigned], ['status', '<>', 'COMPLETED']])->orderBy('created_at', 'desc')->paginate(40);
            return view('pages.order.incomplete_order')->with('incompleteOrders', $incompleteOrders);
        } catch (\Throwable $th) {
            throw $th;
            // return back()->with(['error' => 'Internal server error']);
        }
    }

    /**
     * Assign a rider to incomplete order
     */
    public function assignRiderToIncompleteOrder(Request $request, $id)
    {
        $this->validate($request, [
            'rider' => 'required'
        ]);
        $assignedRider = $request->rider;
        $isAssigned = 1;
        $status = 'PENDING';
        try {
            $order = Order::find($id);
            $rider = Rider::where('email', $assignedRider)->firstOrFail();
            $rider_id = $rider->id;
            if ($order->rider_id != '') {
                return back()->with('error', ' A rider as already been assigned to this pack');
            } else {
                $order->rider_id = $rider_id;
                $order->is_assigned = $isAssigned;
                $order->status = $status;
                $order->save();
                return redirect('/all-orders')->with('success', ' Rider assigned successfuly!');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', ' Internal server error! Please contact the admin');
        }
    }

    /**
     * Complete order request
     */
    public function orderCompleted(Request $request)
    {
        $this->validate($request, [
            'samples' => 'required|numeric',
            'lab' => 'required',
            'id' => 'required'
        ]);
        $id = $request->id;
        $samples = $request->samples;
        $lab = $request->lab;
        $status = 'COMPLETED';
        $isCompleted = 1;

        try {
            // The receiver is lab
            // Get the lab details
            $getLab = Lab::where('fullname', $lab)->firstOrFail();
            // Find order by id
            $order = Order::find($id);
            if (!$order->is_assigned) {
                return response()->json('Please assign a rider to this order');
            }
            // Is it completed already
            if ($order->is_completed) {
                return response()->json('Order already completed');
            }
            $order->status = $status;
            $order->is_completed = $isCompleted;
            $order->save();
            // Increment lab supplies
            $getLab->increment('supplies', $samples);
            return response()->json('Order completed successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $roleId = 8;
            $lgas = User::all();
            $labs = Lab::all();
            $riders = Rider::all();
            return view('pages.order.create_order', compact(['lgas', $lgas, 'labs', $labs, 'riders', $riders]));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'labName' => 'required',
            'deliveryRegion' => 'required',
            'deliveryAddress' => 'required',
            'deliveryContactName' => 'required',
            'deliveryContactPhone' => 'required|numeric',
            // 'quantity' => 'required|numeric',
        ]);

        $labName = $request->labName;
        $deliveryRegion = $request->deliveryRegion;
        $deliveryAddress = $request->deliveryAddress;
        $deliveryContactName = $request->deliveryContactName;
        $deliveryContactPhone = $request->deliveryContactPhone;
        $quantity = $request->quantity ?? 1;

        try {
            // Proccess order
            $lab = Lab::where('fullname', $labName)->firstOrFail();
            $lab_id = $lab->id;
            $newOrder = new Order();
            $newOrder->uuid = Uuid::uuid4();
            $newOrder->user_id = Auth::user()->id;
            $newOrder->lab_id = $lab_id;
            $newOrder->pickupRegion = Auth::user()->region;
            $newOrder->pickupAddress = Auth::user()->address;
            $newOrder->deliveryRegion = $deliveryRegion;
            $newOrder->deliveryAddress = $deliveryAddress;
            $newOrder->deliveryContactName = $deliveryContactName;
            $newOrder->deliveryContactPhone = $deliveryContactPhone;
            $newOrder->quantity = $quantity;
            $newOrder->save();
            return redirect('/all-orders')->with('success', ' Order created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', ' Internal server error! Please contact the admin');
        }
    }

    /**
     * CBL Admin create order
     */
    public function adminOrder(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'lgaName' => 'required',
            'pickupRegion' => 'required',
            'pickupAddress' => 'required',
            'deliveryRegion' => 'required',
            'deliveryAddress' => 'required',
            'deliveryContactName' => 'required',
            'deliveryContactPhone' => 'required|numeric',
            'quantity' => 'required|numeric',
            'labName' => 'required',
            'rider' => 'required',
        ]);

        $lgaName = $request->lgaName;
        $pickupRegion = $request->pickupRegion;
        $pickupAddress = $request->pickupAddress;
        $deliveryRegion = $request->deliveryRegion;
        $deliveryAddress = $request->deliveryAddress;
        $deliveryContactName = $request->deliveryContactName;
        $deliveryContactPhone = $request->deliveryContactPhone;
        $quantity = $request->quantity;
        $labName = $request->labName;
        $assignedRider = $request->rider;
        $isAssigned = 1;
        $status = 'PENDING';
        try {
            //code...
            $lab = Lab::where('fullname', $labName)->firstOrFail();
            $lab_id = $lab->id;
            try {
                //code...
                $lga = User::where('fullname', $lgaName)->firstOrFail();
                $lga_id = $lga->id;
                try {
                    //code...
                    $rider = Rider::where('email', $assignedRider)->firstOrFail();
                    $rider_id = $rider->id;
                    // Proccess order
                    try {
                        $newOrder = new Order();
                        $newOrder->uuid = Uuid::uuid4();
                        $newOrder->user_id = $lga_id;
                        $newOrder->rider_id = $rider_id;
                        $newOrder->lab_id = $lab_id;
                        $newOrder->pickupRegion = $pickupRegion;
                        $newOrder->pickupAddress = $pickupAddress;
                        $newOrder->deliveryRegion = $deliveryRegion;
                        $newOrder->deliveryAddress = $deliveryAddress;
                        $newOrder->deliveryContactName = $deliveryContactName;
                        $newOrder->deliveryContactPhone = $deliveryContactPhone;
                        $newOrder->quantity = $quantity;
                        $newOrder->status = $status;
                        $newOrder->is_assigned = $isAssigned;
                        $newOrder->save();
                        return redirect('/all-orders')->with('success', ' Sample request created successfully');
                    } catch (\Throwable $th) {
                        throw $th;
                        // return back()->with('error', ' Internal server error');
                    }
                } catch (\Throwable $th) {
                    throw $th;
                    // return back()->with('error', ' Internal server error');

                }
            } catch (\Throwable $th) {
                throw $th;
                // return back()->with('error', ' Internal server error');
            }
        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('error', ' Internal server error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $isAssigned = 1;
            $iscompleted = 0;
            $orders = Order::with(['user' => function ($query) {
                $query->withTrashed();
            }])->where('status', "<>", "COMPLETED")->orderBy('created_at', 'desc')->paginate(10);
            return view('pages.order.pending_order')->with('orders', $orders);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $role = 2;
        $riders = Rider::all();
        $labs = Lab::all();
        $LSBs = User::where('role_id', $role)->orderBy('created_at', 'desc')->paginate(20);
        $order = Order::where('uuid', $uuid)->first();
        return view('pages.order.order_details', compact('order', $order, 'riders', $riders, 'LSBs', $LSBs, 'labs', $labs));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
        ]);

        $id = $request->id;
        $status = 'PICKED-UP';
        $order = Order::find($id);
        if ($order) {
            $order->status = $status;
            $order->save();
            return response()->json('Order due for pick up');
        } else {
            return response()->json('Unable to request for pick up');
        }
    }

    public function editStatus($uuid)
    {
        try {
            //code...
            $order = Order::where('uuid', $uuid)->first();
            return view('pages.order.edit_status')->with('order', $order);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $status = $request->status;
        $order = Order::find($id);
        if ($order) {
            $order->status = $status;
            $order->save();
            return back()->with('success', 'Status Updated');
        } else {
            return back()->with('error', 'Unable to update status');
        }
    }

    /**
     * Show listing of all completed order
     */
    public function completedOrders()
    {
        try {
            //code...
            $orders = Order::with(['user' => function ($query) {
                $query->withTrashed();
            }])
                ->where('status', "COMPLETED")->orderBy('created_at', 'desc')->paginate(20);
            return view('pages.order.completed_orders')->with('orders', $orders);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Internal server error' . $th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required'
        ]);
        $comment = $request->comment;
        $deleteOrder = Order::find($id);
        if ($deleteOrder) {
            $orderId = $deleteOrder->id;
            $reason = new Reason();
            $reason->uuid = Uuid::uuid4();
            $reason->order_id = $orderId;
            $reason->comment = $comment;
            $reason->save();
            $deleteOrder->delete();
            return redirect('/all-orders')->with('success', 'Order deleted successfully');
        } else {
            return back()->with('error', 'Unable to delete order');
        }
    }

    /**
     * Get deleted resource
     */
    public function deletedOrders()
    {
        try {
            //code...
            $deletedOrders = Order::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(20);
            return view('pages.order.deleted_order')->with('deletedOrders', $deletedOrders);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => 'An error occur while loading this page']);
        }
    }

    /**
     * Deleted resource details
     */
    public function deletedOrderDetails($uuid)
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $deletedOrder = Order::onlyTrashed()->where('uuid', $uuid)->firstOrFail();
            return view('pages.order.deleted_order_details')->with('deletedOrder', $deletedOrder);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function downloadOrderInfoTemplate()
    {
        return Excel::download(new OrderInfoTemplateExport, 'orderInfoTemplate.xlsx');
    } //end method downloadOrderInfoTemplate

    public function importBulk(Request $request)
    {
        $request->validate([
            'file' => "required|mimes:xlsx"
        ]);

        Excel::import(new OrderImport, $request->file('file'));

        return back()->with("success", " Bulk imports made successfully");
    }
}
