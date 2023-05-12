<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OxygenAddRequest;
use App\OxygenPlant;
use App\OxygenSize;

class OxygenAddRequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'plant' => "required",
            'size' => "required",
            'count' => "required|numeric",
            'receivedFrom' => 'required|string',
            'collectedBy' => 'required|string'
        ]);

        if (OxygenPlant::where('id', $request->plant)->count() <= 0)
            return back()->with('error', "Oxygen Plant not found");

        if (OxygenSize::where('id', $request->size)->count() <= 0)
            return back()->with('error', "Oxygen Size not found");

        $addRequest = new OxygenAddRequest([
            'oxygen_plant_id' => $request->plant,
            'oxygen_size_id' => $request->size,
            'count' => $request->count,
            'collectedBy' => $request->collectedBy,
            'receivedFrom' => $request->receivedFrom
        ]);

        $addRequest->save();

        return back()->with('success', "The addition to the plant has been made");
    } //end method store
}//end class OxygenAddRequestController
