<?php

namespace App\Http\Controllers;

use App\Warehouse;
use App\Inventory;
use Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

use App\Exports\WarehouseSheetExport;
use Maatwebsite\Excel\Facades\Excel;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        if (Gate::allows('isSuperAdmin')) {
            try {
                //code...
                $warehouses = Warehouse::withTrashed()->with('cancelingUser:id,uuid,fullname')->orderBy('created_at', 'desc')->paginate(20);

                //NOTE: each warehouse has an additional attribute called 'noOfCarePacks'
                return view('pages.warehouse.manage_warehouse')->with(['warehouses' =>  $warehouses]);
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with(['error' => 'Internal server error']);
            }
        } else {
            return Response::deny('You must be a super administrator.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'location' => 'required',
            'address' => 'required',
            // 'admin' => 'required',
        ]);

        $location = $request->location;
        $address = $request->address;
        // $adminName = $request->adminName;
        // Convert pack name to lower case
        $convert = Str::of($location)->lower();
        try {
            //code...
            $warehouse = Warehouse::where('location', $convert)->exists();
            // Check if warehouse already exit
            if ($warehouse) {
                return back()->with('error', ' Warehouse already exist');
            } else {
                try {
                    //code...
                    // $admin = User::where('fullname', $adminName)->firstOrFail();
                    // $admin_id = $admin->id;

                    $newWarehouse = new Warehouse();
                    $newWarehouse->uuid = Uuid::uuid4();
                    // $newWarehouse->admin_id = $admin_id;
                    $newWarehouse->location = $convert;
                    $newWarehouse->address = $address;
                    $newWarehouse->save();
                    // Redirect user
                    return back()->with('success', ' New Warehouse Created Successfully');
                } catch (\Throwable $th) {
                    throw $th;
                    // return redirect()->back()->with(['error' => 'Internal server error']);
                }
            }
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with(['error' => 'Internal server error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }

    public function cancelWarehouse(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $user = auth()->user();

        $warehouse = null;

        try {
            $warehouse = Warehouse::findOrFail($request->id);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => 'Warehouse not found']);
        }

        $warehouse->canceled = true;
        $warehouse->cancelingUser()->associate($user);
        $warehouse->dateCanceled = now();
        $warehouse->save();

        $warehouse->delete();

        return back()->with('success', " Warehouse successfully canceled");
    } //end method cancelWarehouse

    public function downloadWarehouseSheet()
    {
        return Excel::download(new WarehouseSheetExport, 'warehouses.xlsx');
    } //end method downloadWarehouseSheet
}
