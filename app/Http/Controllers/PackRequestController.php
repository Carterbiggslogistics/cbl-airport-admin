<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\PackInfoTemplateExport;
use App\Imports\PackImport;
use Maatwebsite\Excel\Facades\Excel;
use App\PackRequest;
use App\Rider;
use App\Warehouse;
use App\Inventory;

class PackRequestController extends Controller
{
    public function __construc()
    {
        $this->middleware('can:isAdmin');
    } //end constructor method

    public function downloadPackInfoTemplate()
    {
        return Excel::download(new PackInfoTemplateExport, 'packInfoTemplate.xlsx');
    } //end method downloadPackInfoTemplate


    public function index(Request $request)
    {

        $status = $request->status;

        $packRequestsQuery = PackRequest::query();

        if ($status) $packRequestsQuery->where("status", $status);

        $packRequests = $packRequestsQuery->latest()->paginate(20);

        $statuses = collect(PackRequest::STATUS);

        return view("pages.pack.all_pack_requests", \compact(
            'packRequests',
            'statuses'
        ));
    } //end method index

    public function create()
    {
        $riders = Rider::all();
        $warehouses = Warehouse::all();

        return view('pages.pack.pack_request', [
            'riders' => $riders,
            'warehouses' => $warehouses
        ]);
    } //end method create

    public function store(Request $request)
    {
        $request->validate([
            // 'description' => 'required,
            'quantity' => 'required|numeric',
            'pickupRegion' => 'required|string',
            'pickupAddress' => "required|string",
            'deliveryRegion' => 'required|string',
            'deliveryAddress' => 'required|string',
            'deliveryContactName' => 'required|string',
            'deliveryContactPhone' => 'required|string',
            'rider' => 'required',
            'warehouse' => 'required',

        ]);

        $rider = Rider::find($request->rider);
        if ($rider == null) back()->with('error', 'The rider is invalid');

        $warehouse = Warehouse::find($request->warehouse);
        if ($warehouse == null) back()->with('error', 'The warehouse is invalid');

        $packRequest = new PackRequest(
            $request->only(
                'quantity',
                'description',
                'pickupRegion',
                'pickupAddress',
                'deliveryRegion',
                'deliveryAddress',
                'deliveryContactName',
                'deliveryContactPhone'
            )
        );

        $packRequest->warehouse()->associate($warehouse);
        $packRequest->rider()->associate($rider);
        $packRequest->user()->associate(auth()->user());

        $packRequest->status = PackRequest::STATUS['TRANSIT'];

        $packRequest->save();

        return back()->with('success', 'Request made successfully');
    } //end metho store

    public function importBulk(Request $request)
    {
        $request->validate([
            'file' => "required|mimes:xlsx"
        ]);

        Excel::import(new PackImport, $request->file('file'));

        return back()->with("success", " Bulk imports made successfully");
    } //end method importBulk

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        if (!key_exists($request->status, PackRequest::STATUS))
            return back()->with('error', 'invalid value for status');

        $packRequest = PackRequest::find($request->id);

        if ($packRequest == null)
            return back()->with('error', 'Pack request request not found');

        if ($packRequest->status == PackRequest::STATUS['CANCELED'])
            return back()->with('error', 'This pack request has been canceled, and cannot be edited');

        $packRequest->status = PackRequest::STATUS[$request->status];

        $packRequest->save();

        return redirect("/all-care-pack-requests")->with('success', 'Updated successfully');
    } //end method chageStatus
}//end class PackRequestController
