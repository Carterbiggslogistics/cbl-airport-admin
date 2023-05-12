<?php

namespace App\Http\Controllers;

use App\AssignedRider;
use Illuminate\Http\Request;

class AssignedRiderController extends Controller
{
    public function __construct()
    {
        $this->authorize('isSuperAdmin');

    }
    
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssignedRider  $assignedRider
     * @return \Illuminate\Http\Response
     */
    public function show(AssignedRider $assignedRider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssignedRider  $assignedRider
     * @return \Illuminate\Http\Response
     */
    public function edit(AssignedRider $assignedRider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssignedRider  $assignedRider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssignedRider $assignedRider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssignedRider  $assignedRider
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssignedRider $assignedRider)
    {
        //
    }
}
