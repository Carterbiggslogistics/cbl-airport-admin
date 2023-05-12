<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Access\Gate;
use App\OxygenClient;

class OxygenClientController extends Controller
{
    public function __contruct(Gate $gate)
    {
        $gate->define('access-oxygen-client-controller', fn ($user) => $user->can('isSuperAdmin') || $user->can('oxygen-admin'));

        $this->middleware('can:access-oxygen-client-controller');
    } //end contructor method

    public function index()
    {
        $oxygenClients = OxygenClient::latest()->paginate(20);

        return view('pages.oxygen.manage_client', compact('oxygenClients'));
    } //end method index

    public function create()
    {
        return view('pages.oxygen.create_client');
    } //end method create

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'state' => 'required',
            'country' => 'required',
            'address' => 'required',
            'region' => 'required',
            'city' => 'required',
            
        ]);

        if (OxygenClient::where('email', $request->email)->first() != null) {
            return back()->with('error', "The client with this email already exists");
        }

        $oxygenClient = new OxygenClient($request->only(
            'name',
            'email',
            'phoneNumber',
            'state',
            'country',
            'address',
            'region',
            'city',
            'pricePerUnit',
        ));

        $oxygenClient->save();

        return back()->with('success', "The oxygen client has been created successfully");
    } //end method store


}//end class OxygenClientController
