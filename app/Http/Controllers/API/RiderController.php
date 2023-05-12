<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function updateLocation(Request $request)
    {
        $request->validate([
            'long' => 'required|numeric',
            'lat' => 'required|numeric'
        ]);


        $rider = auth()->guard('api')->user();

        $rider->location_long = $request->long;
        $rider->location_lat = $request->lat;

        $rider->save();

        return response()->json(["message" => "Rider location updated '{$request->lat}, {$request->long}'"]);
    } //end method updateLocation
}//end class RiderController
