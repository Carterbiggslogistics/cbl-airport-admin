<?php

namespace App\Http\Controllers;

use App\Item;
use Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'item' => 'required',
        ]);

        $name = $request->item;
        // Convert pack name to lower case
        $convertName = Str::of($name)->lower();
        try {
            //code...
            $pack = Item::where('name', $convertName)->exists();
            // Check if pack already exit
            if($pack){
                return back()->with('error', ' Item already exist');
            }else {
                try {
                    //code...
                    $newpack = new Item();
                    $newpack->uuid = Uuid::uuid4();
                    $newpack->name = $convertName;
                    $newpack->save();
                    // Redirect user
                    return back()->with('success', ' New item Created Successfully');
                } catch (\Throwable $th) {
                    // throw $th;
                    return redirect()->back()->with(['error' => 'Internal server error']);
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
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
