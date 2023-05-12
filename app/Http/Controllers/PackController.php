<?php

namespace App\Http\Controllers;

use App\Pack;
use App\Category;
use App\Item;
use App\Warehouse;
use Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //code...
            $packs = Pack::orderBy('created_at', 'desc')->whereHas('warehouse')->with('warehouse')->paginate(20);
            $warehouses = Warehouse::all();

            // dd($packs);
            return view('pages.inventory.manage_packs', compact(['packs', $packs, 'warehouses', $warehouses]));
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->back()->with(['error' => 'Internal server error']);
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
            'quantity' => 'required|numeric',
            'warehouse' => 'required',
            'collectedBy' => 'required',
            'receivedFrom' => 'required'
        ]);

        $quantity = $request->quantity;
        $selectedWarehouse = $request->warehouse;
        $collectedBy = $request->collectedBy;
        $receivedFrom = $request->receivedFrom;
        // Convert pack name to lower case
        try {
            //code...
            $category = Category::where('name', 'care pack')->firstOrFail();
            $cat_id = $category->id;
            $warehouse = Warehouse::where('location', $selectedWarehouse)->firstOrFail();
            $warehouse_id = $warehouse->id;
            //Get role by name
            $newpack = new Pack();
            $newpack->uuid = Uuid::uuid4();
            $newpack->user_id = Auth::user()->id;
            $newpack->category_id = $cat_id;
            $newpack->warehouse_id = $warehouse_id;
            $newpack->name = "Care Pack";
            $newpack->quantity = $quantity;
            $newpack->collectedBy = $collectedBy;
            $newpack->receivedFrom = $receivedFrom;
            $newpack->save();
            // Redirect user
            return back()->with('success', ' New item Created Successfully');
        } catch (\Throwable $th) {
            throw $th;
            // return redirect()->back()->with(['error' => 'Internal server error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function show(Pack $pack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function edit(Pack $pack)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pack $pack)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pack  $pack
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pack $pack)
    {
        //
    }
}
