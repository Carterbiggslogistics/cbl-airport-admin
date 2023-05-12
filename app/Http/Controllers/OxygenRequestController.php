<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Access\Gate;

use App\OxygenPlant;
use App\OxygenClient;
use App\OxygenRequest;
use App\OxygenSize;
use App\OxygenSupply;

class OxygenRequestController extends Controller
{
    public function __contruct(Gate $gate)
    {
        $gate->define('access-oxygen-client-controller', fn ($user) => $user->can('isSuperAdmin') || $user->can('oxygen-admin'));

        $this->middleware('can:access-oxygen-client-controller');
    } //end contructor method

    public function index(Request $request)
    {
        $isPickupRequest = $request->pickupRequest == true ? true : false;

        $oxygenRequestsQuery = OxygenRequest::with(
            'client',
            'plant'
        )->latest();

        if ($isPickupRequest)
            $oxygenRequestsQuery->where('isRequestingPickup', true);

        $oxygenRequests = $oxygenRequestsQuery->simplePaginate(15);
        return view('pages.oxygen.manage_request', compact('oxygenRequests'));
    } //end method index

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        if (!key_exists($request->status, OxygenRequest::STATUS))
            return back()->with('error', 'invalid value for status');

        $oxygenRequest = OxygenRequest::find($request->id);

        if ($oxygenRequest == null)
            return back()->with('error', 'Oxygen request not found');

        $oxygenRequest->status = OxygenRequest::STATUS[$request->status];

        if ($oxygenRequest->status == OxygenRequest::STATUS['PICKED-UP']) {
            $oxygenRequest->isRequestingPickup = false;
            $oxygenRequest->pickupDate = now();
        } else {
            $oxygenRequest->pickupDate = null;
        }

        $oxygenRequest->save();

        return redirect("/oxygen/request/{$request->id}")->with('success', 'Updated successfully');
    } //end method chageStatus

    public function requestPickup(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $oxygenRequest = OxygenRequest::find($request->id);

        if ($oxygenRequest == null)
            return back()->with('error', 'Oxygen request not found');

        if ($oxygenRequest->status != OxygenRequest::STATUS['DELIVERED'])
            return back()->with('error', 'Only delivered requests can request for pickup');

        $oxygenRequest->isRequestingPickup = true;
        $oxygenRequest->save();
        return redirect("/oxygen/request/{$request->id}")->with('success', 'Pickup requested!');
    } //end method requestPickup



    public function create()
    {
        $oxygenPlants = OxygenPlant::orderBy('name')->get();
        $oxygenClients = OxygenClient::orderBy('name')->get();
        $oxygenSizes = OxygenSize::orderBy('size')->get();

        return view('pages.oxygen.create_request', compact(
            'oxygenPlants',
            'oxygenClients',
            'oxygenSizes',
        ));
    } //end method index

    public function show(Request $request, $id)
    {
        $oxygenRequest = OxygenRequest::with(
            'client',
            'plant',
            'supplies.size'
        )->where('id', $id)->first();

        $statuses =  collect(OxygenRequest::STATUS);

        if ($oxygenRequest == null) {
            //TODO: Find how to return a 404 error
            return response()->view('errors.404', [
                'title' => '404',
                'name' => 'Page not found'
            ], 404);
        }

        return view('pages.oxygen.request_details', compact(
            'oxygenRequest',
            'statuses'
        ));
    } //end method show

    public function store(Request $request)
    {
        $request->validate([
            'plant' => 'required',
            'client' => 'required',
            'size' => 'required',
            'noOfCylinders' => 'required'
        ]);

        $sizesIds = $request->input('size');
        $noOfCylindersArray = $request->input('noOfCylinders');

        if (count($sizesIds) != count($noOfCylindersArray))
            return back()->with('error', 'The sizes list and the no of cylinders do not math');

        $plant = OxygenPlant::find($request->plant);
        if ($plant == null)
            return back()->with("error", "The plant is not found");

        $client = OxygenClient::find($request->client);
        if ($client == null)
            return back()->with("error", "The plant is not found");

        $oxygenSupplies = [];
        $oxygenSizes = OxygenSize::whereIn('id', $sizesIds)->get();

        for ($i = 0; $i < count($sizesIds); $i++) {
            if ($oxygenSizes->where('id', $sizesIds[$i])->first() == null) continue;

            $tSize = $oxygenSizes->where('id', $sizesIds[$i])->first();
            $availableCylindersInPlant = $plant->getNoOfCylindersFromSize($tSize);

            if ($availableCylindersInPlant < $noOfCylindersArray[$i]) {
                return back()->with(
                    'error',
                    "The plant only has $availableCylindersInPlant cylinders for size {$tSize->size} cm3, {$noOfCylindersArray[$i]} given"
                );
            }

            $oxygenSupplies[] = new OxygenSupply([
                'oxygen_size_id' => $sizesIds[$i],
                'noOfCylinders' => $noOfCylindersArray[$i]
            ]);
        }

        $oxygenRequest = new OxygenRequest();
        $oxygenRequest->oxygen_client_id = $client->id;
        $oxygenRequest->oxygen_plant_id = $plant->id;
        $oxygenRequest->user_id = auth()->user()->id;
        $oxygenRequest->status = OxygenRequest::STATUS['ON-ROUTE'];

        $totalVolume = 0.0;
        for ($i = 0; $i < count($sizesIds); $i++) {
            $totalVolume = $oxygenSizes->where('id', $sizesIds[$i])->first()->size * $noOfCylindersArray[$i];
        }
        $oxygenRequest->price = $totalVolume * $client->pricePerUnit;

        $oxygenRequest->save();

        foreach ($oxygenSupplies  as $supply) {
            // try {
            $oxygenRequest->supplies()->save($supply);
            // } catch (\Throwable $th) {
            //     return back()->with('error', 'internal server error');
            // }
        }

        return back()->with("success", "Oxygen request made successfully");
    } //end method store
}//enc lass OxygenRequestController
