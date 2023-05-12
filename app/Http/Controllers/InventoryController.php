<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\Pack;
use App\Item;
use App\User;
use App\Rider;
use App\Warehouse;
use App\Activity;
use Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //code...
        $userId = Auth::user()->id;
        $inventories = Inventory::orderBy('created_at', 'desc')->paginate(20);
        $myInventories = Inventory::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(20);
        return view('pages.inventory.manage_inventories', compact(['inventories', $inventories, 'myInventories', $myInventories]));

    }

     /**
     * Show listing of all completed order
     */
    public function deliveredCarePacks()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $isDelivered = 1;
            $inventories = Inventory::where('is_delivered', $isDelivered)->orderBy('created_at', 'desc')->paginate(20);
            return view('pages.inventory.completed_inventories')->with('inventories', $inventories);
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Internal server error'.$th);
        }
    }

    /**
     * List all not assigned request
     */
    public function incompleteInventories()
    {
        if (Auth::guest()){
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $notDelivered = 0;
            $notAssigned = 0;
            $incompleteRequests = Inventory::where('is_delivered', $notDelivered)->where('is_assigned', $notAssigned)->orderBy('created_at', 'desc')->paginate(40);
            return view('pages.inventory.incomplete_inventories')->with('incompleteRequests', $incompleteRequests);
        } catch (\Throwable $th) {
            throw $th;
            // return redirect()->back()->with(['error' => 'Internal server error']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guest()){
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            $warehouses = Warehouse::all();
            $packs = Item::all();
            $riders = Rider::all();
            return view('pages.inventory.pack_request', compact(['packs', $packs, 'warehouses', $warehouses, 'riders', $riders]));
        } catch (\Throwable $th) {
            //throw $th;
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
            'pack' => 'required',
            'deliveryRegion' => 'required',
            'deliveryAddress' => 'required',
            'deliveryContactName' => 'required',
            'deliveryContactPhone' => 'required|numeric',
            'quantity' => 'required|numeric',
        ]);

        $packName = $request->pack;
        $quantity = $request->quantity;
        $deliveryRegion = $request->deliveryRegion;
        $deliveryAddress = $request->deliveryAddress;
        $deliveryContactName = $request->deliveryContactName;
        $deliveryContactPhone = $request->deliveryContactPhone;
        /**
         * Calculate amount
         * Each care pack cost #300
         */
        $amount = $quantity * 300;
        try {
            $pack = Pack::where('name', $packName)->firstOrFail();
            $packId = $pack->id;
            // Proccess order
            $newInventory = new Inventory();
            $newInventory->uuid = Uuid::uuid4();
            $newInventory->user_id = Auth::user()->id;
            $newInventory->pack_id = $packId;
            $newInventory->amount = $amount;
            $newInventory->quantity = $quantity;
            $newInventory->deliveryRegion = $deliveryRegion;
            $newInventory->deliveryAddress = $deliveryAddress;
            $newInventory->deliveryContactName = $deliveryContactName;
            $newInventory->deliveryContactPhone = $deliveryContactPhone;
            // $newInventory->status = 'Successful';
            $newInventory->save();
            return redirect('/all-care-packs')->with('success', ' Request made successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', ' Internal server error');
        }
    }

    /**
     * Let create a method for admin to create pack request
     */
    public function adminRequest(Request $request)
    {
        $this->validate($request, [
            'pack' => 'required',
            'deliveryRegion' => 'required',
            'deliveryAddress' => 'required',
            'deliveryContactName' => 'required',
            'deliveryContactPhone' => 'required|numeric',
            'quantity' => 'required|numeric',
            'assignedRider' => 'required',
            'warehouse' => 'required',
        ]);

        $packName = $request->pack;
        $quantity = $request->quantity;
        $deliveryRegion = $request->deliveryRegion;
        $deliveryAddress = $request->deliveryAddress;
        $deliveryContactName = $request->deliveryContactName;
        $deliveryContactPhone = $request->deliveryContactPhone;
        $assignedRider = $request->assignedRider;
        $pickupWarehouse = $request->warehouse;
        /**
         * Calculate amount
         * Each care pack cost #300
         */
        $amount = $quantity * 300;
        $isAssigned = 1;
        $status = Inventory::STATUS['RELEASED'];
        try {
            //code...
            $pack = Pack::where('name', $packName)->firstOrFail();
            $packId = $pack->id;
            
            $warehouse = Warehouse::where('location', $pickupWarehouse)->firstOrFail();
            $warehouse_id = $warehouse->id;

            $rider = Rider::where('email', $assignedRider)->firstOrFail();
            $rider_id = $rider->id;
            /**
             * Check if the warehouse has enough care pack by getting it total from activity.
             */

            // Total items in a warehouse
            $itemsReceived = Activity::where('pack_id', $packId)->where('transferTo_id', $warehouse_id)->sum('quantity'); // If this warehouse as received any items before
            $itemsInStore = Pack::where('name', 'care pack')->where('warehouse_id', $warehouse_id)->sum('quantity'); // Total carepack in store
            $carepackQty = $itemsReceived + $itemsInStore;
            if($carepackQty < $quantity){
                return back()->with('error', ' '. $pickupWarehouse . ' does not have enough care packs to perform this action!');
            }
            
            $newInventory = new Inventory();
            $newInventory->uuid = Uuid::uuid4();
            $newInventory->user_id = Auth::user()->id;
            $newInventory->rider_id = $rider_id;
            $newInventory->pack_id = $packId;
            $newInventory->warehouse_id = $warehouse_id;
            $newInventory->amount = $amount;
            $newInventory->quantity = $quantity;
            $newInventory->deliveryRegion = $deliveryRegion;
            $newInventory->deliveryAddress = $deliveryAddress;
            $newInventory->deliveryContactName = $deliveryContactName;
            $newInventory->deliveryContactPhone = $deliveryContactPhone;
            $newInventory->is_assigned = $isAssigned;
            $newInventory->status = $status;
            $newInventory->save();
            return redirect('/all-care-packs')->with('success', ' Request made successfully');
        } catch (\Throwable $th) {
            throw $th;
            // return back()->with('error', ' Internal server error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
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
            $warehouses = Warehouse::all();
            $inventory = Inventory::where('uuid', $uuid)->first();
            return view('pages.inventory.request_details', compact(['inventory', $inventory, 'riders', $riders, 'warehouses', $warehouses]));
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', ' Internal server error');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    /**
     * Assign rider
     */
    public function assignRider(Request $request, $id)
    {
        $this->validate($request, [
            'rider' => 'required',
            'warehouse' => 'required'
        ]);
        $assignedRider = $request->rider;
        $pickupWarehouse = $request->warehouse;
        $isAssigned = 1;
        $status = Inventory::STATUS['RELEASED'];
        try {
            //code...
            $inventory = Inventory::find($id);
            $warehouse = Warehouse::where('location', $pickupWarehouse)->firstOrFail();
            $warehouse_id = $warehouse->id;
            if($inventory){
                $packId = $inventory->pack_id;
                $quantity = $inventory->quantity;
                /**
                 * Check if the warehouse has enough care pack by getting it total from activity.
                 */

                // Total items in a warehouse
                $itemsReceived = Activity::where('pack_id', $pack_id)->where('transferTo_id', $warehouse_id)->sum('quantity'); // If this warehouse as received any items before
                $itemsInStore = Pack::where('name', 'care pack')->where('warehouse_id', $warehouse_id)->sum('quantity'); // Total carepack in store
                $carepackQty = $itemsReceived + $itemsInStore;
                if($carepackQty < $quantity){
                    return back()->with('error', ' '. $pickupWarehouse . ' does not have enough care packs to perform this action!');
                }
                try {
                    //code...
                    $rider = Rider::where('email', $assignedRider)->firstOrFail();
                    $rider_id = $rider->id;
                    if($inventory->rider_id != ''){
                        return back()->with('error', ' A rider as already been assigned to this pack');
                    }else {
                        $inventory->rider_id = $rider_id;
                        $inventory->warehouse_id = $warehouse_id;
                        $inventory->is_assigned = $isAssigned;
                        $inventory->status = $status;
                        $inventory->save();
                        return redirect('/all-care-packs')->with('success', ' Request made successfully');
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                    return back()->with('error', ' Internal server error');
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * change status to delivered
     */
    public function inventoryDelivered(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $id = $request->id;
        $status = Inventory::STATUS['DELIVERED'];
        $isDelivered = 1;

        try {
            //code...
            $inventory = Inventory::find($id);
            if(!$inventory->is_assigned){
                return response()->json('Please assign a rider to this inventory');
            }
            if($inventory->is_delivered){
                return response()->json('Inventory already delivered');
            }
            $inventory->status = $status;
            $inventory->is_delivered= $isDelivered;
            $inventory->save();
            return response()->json('Inventory completed successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', ' Internal server error');
        }
    }
}
