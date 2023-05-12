<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OxygenPlant;
use Illuminate\Contracts\Auth\Access\Gate;

class OxygenPlantController extends Controller
{
    public function __contruct(Gate $gate)
    {
        $gate->define('access-oxygen-plant-controller', fn ($user) => $user->can('isSuperAdmin') || $user->can('oxygen-admin'));

        $this->middleware('can:access-oxygen-plant-controller');
    } //end contructor method

    public function index()
    {
        $oxygenPlants = OxygenPlant::latest()->paginate(20);
        return view('pages.oxygen.manage_plant', compact(
            'oxygenPlants'
        ));
    } //end method index

    public function create()
    {
        return view('pages.oxygen.create_plant');
    } //end method create

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'region' => 'required|string',
            'city' => 'required|string',
        ]);

        if (OxygenPlant::where('email', $request->email)->first() != null) {
            return back()->with('error', "The plant with this email already exists");
        }

        $oxygenPlant = new OxygenPlant($request->only(
            'name',
            'address',
            'email',
            'phoneNumber',
            'state',
            'country',
            'region',
            'city'
        ));

        $oxygenPlant->save();

        return back()->with('success', "Plant created successfully");
    } //end method store
}//end class OxygenPlantController
