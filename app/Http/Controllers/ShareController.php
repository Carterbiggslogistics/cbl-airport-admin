<?php

namespace App\Http\Controllers;

use App\Share;
use App\Lab;
use App\Rider;
use Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ShareController extends Controller
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
        try {
            //code...
            $notDelivered = 0;
            $notAssigned = 0;
            $shares = Share::where('is_delivered', $notDelivered)->where('is_assigned', $notAssigned)->orderBy('created_at', 'desc')->paginate(40);
            return view('pages.order.share_requests')->with('shares', $shares);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => 'An error occur while loading this page']);
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
            'labA' => 'required',
            'labB' => 'required',
            'supplies' => 'required|numeric',
        ]);
        // Variables
        $labA = $request->labA;
        $labB = $request->labB;
        $supplies = $request->supplies;
        if ($labA === $labB) {
            return back()->with('error', ' You cannot share samples with your lab');
        }
        try {
            //code...
            $sender = Lab::where('email', $labA)->firstOrFail();
            $receiver = Lab::where('email', $labB)->firstOrFail();
            if ($sender->supplies < $supplies) {
                return back()->with('error', 'You don\'t have enough samples to perform this action');
            }
            // Collect IDs
            $sender_id = $sender->id;
            $receiver_id = $receiver->id;
            // Decrease Lab A supplies
            $sender->decrement('supplies', $supplies);
            // Create new Share Instance
            $newShare = new Share();
            $newShare->uuid = Uuid::uuid4();
            $newShare->user_id = Auth::user()->id;
            $newShare->labA_id = $sender_id;
            $newShare->labB_id = $receiver_id;
            $newShare->samples = $supplies;
            $newShare->save();
            return redirect('/all-share-requests')->with(['success' => ' Samples successfully shared to ' . $receiver->fullname]);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with(['error' => ' Cannot share samples' . $th]);
        }
    }

    /**
     * CBL admin share for lab
     */
    public function cblShare(Request $request)
    {
        $this->validate($request, [
            'labA' => 'required',
            'labB' => 'required',
            'supplies' => 'required|numeric',
            'rider' => 'required',
        ]);
        // Variables
        $labA = $request->labA;
        $labB = $request->labB;
        $supplies = $request->supplies;
        $assignedRider = $request->rider;
        $isAssigned = 1;
        $status = "Pending";
        if ($labA === $labB) {
            return back()->with('error', ' You cannot share supplies with your lab');
        }
        try {
            //code...
            $sender = Lab::where('email', $labA)->firstOrFail();
            $receiver = Lab::where('email', $labB)->firstOrFail();
            if ($sender->supplies < $supplies) {
                return back()->with('error', 'You don\'t have enough samples to perform this action');
            }
            $rider = Rider::where('email', $assignedRider)->firstOrFail();
            $rider_id = $rider->id;
            // Collect IDs
            $sender_id = $sender->id;
            $receiver_id = $receiver->id;
            // Decrease Lab A supplies
            $sender->decrement('supplies', $supplies);
            // Create new Share Instance
            $newShare = new Share();
            $newShare->uuid = Uuid::uuid4();
            $newShare->user_id = Auth::user()->id;
            $newShare->rider_id = $rider_id;
            $newShare->labA_id = $sender_id;
            $newShare->labB_id = $receiver_id;
            $newShare->samples = $supplies;
            $newShare->is_assigned = $isAssigned;
            $newShare->status = $status;
            $newShare->save();
            return redirect('/all-share-requests')->with(['success' => ' Samples successfully shared to ' . $receiver->fullname]);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with(['error' => ' Cannot share samples' . $th]);
        }
    }

    /**
     * Assign a rider to shared supplies
     */
    public function assignRider(Request $request, $id)
    {
        $this->validate($request, [
            'rider' => 'required'
        ]);
        $assignedRider = $request->rider;
        $isAssigned = 1;
        $status = "Pending";
        try {
            //code...
            // Get share request id
            $share = Share::find($id);
            $rider = Rider::where('email', $assignedRider)->firstOrFail();
            $rider_id = $rider->id;
            // Update Share
            $share->is_assigned = $isAssigned;
            $share->rider_id = $rider_id;
            $share->status = $status;
            $share->save();
            // Update receiver lab supplies
            return redirect('/all-share-requests')->with(['success' => ' Rider assigned successfully ']);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', ' Cannot assign rider to this requests ' . $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function show(Share $share)
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        $isAssigned = 1;
        $isDelivered = 0;
        try {
            //code...
            $allShares = Share::orderBy('created_at', 'desc')
                ->paginate(30);
            $shares = Share::where('is_assigned', $isAssigned)
                ->where('is_delivered', $isDelivered)
                ->orderBy('created_at', 'desc')
                ->paginate(30);
            return view('pages.order.all_shares', compact(['shares', $shares, 'allShares', $allShares]));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $riders = Rider::all();
            $share = Share::where('uuid', $uuid)->first();
            return view('pages.order.share_details', compact(['share', $share, 'riders', $riders]));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Deliver samples
     */
    public function deliveredSamples(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'lab' => 'required',
            'samples' => 'required',
        ]);

        $id = $request->id;
        $lab = $request->lab;
        $samples = $request->samples;
        $status = 'Delivered';
        $isDelivered = 1;
        try {
            //code...
            $getLab = Lab::where('email', $lab)->firstOrFail();
            try {
                //code...
                $share = Share::find($id);
                if (!$share->is_assigned) {
                    return response()->json('Please assign a rider to this order');
                }
                if ($share->is_delivered) {
                    return response()->json('Samples delivered already');
                }
                $share->status = $status;
                $share->is_delivered = $isDelivered;
                $share->save();
                $getLab->increment('supplies', $samples);
                return response()->json('Samples delivered successfully');
            } catch (\Throwable $th) {
                throw $th;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show all delivered samples
     */
    public function allDeliveredSamples()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        $isDelivered = 1;
        try {
            //code...
            $userId = Auth::user()->id; 
            $myShares = Share::where('is_delivered', $isDelivered)->where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(20);
            $shares = Share::where('is_delivered', $isDelivered)->orderBy('created_at', 'desc')->paginate(30);
            return view('pages.order.all_delivered_samples', compact(['shares', $shares, 'myShares', $myShares]));
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Change status
     */
    public function changeStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $status = $request->status;
        try {
            //code...
            $share = Share::find($id);
            if ($share->is_delivered) {
                return back()->with('error', ' Samples already delivered! You can not change status');
            }
            $share->status = $status;
            $share->save();
            return redirect('/all-share-requests')->with('success', 'Status Updated');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Unable to update status' . $th);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Share $share)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Share  $share
     * @return \Illuminate\Http\Response
     */
    public function destroy(Share $share)
    {
        //
    }
}