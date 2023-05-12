<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PackTransfer;
use App\Warehouse;
use App\Rider;

class PackTransferController extends Controller
{
    public function __construct() {
        $this->middleware('can:isAdmin');
    }//end constructor method

    public function store(Request $request){
        $request->validate([
            'quantity' => 'required|numeric',
            'receivedFrom' => 'required|string',
            'collectedBy' => 'required|string',
            'warehouseFrom' => 'required',
            'warehouseTo' => 'required',
            'rider' => 'required',
            'reason' => 'required|string',
        ]);

        if($request->warehouseFrom == $request->warehouseTo)
            return back()->with('error', 'A warehouse cannot transfer to itself');


        $warehouseFrom = Warehouse::find($request->warehouseFrom);
        if($warehouseFrom == null) 
            return back()->with('error', 'The warehouse from which packs are to be sent is not found');


        $warehouseTo = Warehouse::find($request->warehouseTo);
        if($warehouseTo == null) 
            return back()->with('error', 'The warehouse to which packs are to be sent is not found');


        if($warehouseFrom->noOfCarePacks < $request->quantity)
            return back()->with('error', 'Not enough packs to transfer');

        

        $rider = Rider::find($request->rider);
        if($rider == null) return back()->with('error', 'Rider can\'t be found');

        $packTransfer = new PackTransfer(
            $request->only(
                'quantity',
                'receivedFrom',
                'collectedBy',
                'reason'
            )
        );

        $packTransfer->status = PackTransfer::STATUS['PENDING'];

        $packTransfer->warehouseFrom()->associate($warehouseFrom);
        $packTransfer->warehouseTo()->associate($warehouseTo);
        $packTransfer->rider()->associate($rider);

        $packTransfer->save();

        return back()->with('success', 'Pack Transfer made successfully');
    }//end method store
}//end class PackTransferController
