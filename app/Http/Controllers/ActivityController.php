<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Inventory;
use App\User;
use App\Pack;
use App\Item;
use App\Category;
use App\Rider;
use App\Location;
use App\Warehouse;
use App\PackRequest;
use App\PackTransfer;
use Auth;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use App\Exceptions\TimeFilterException;
use App\Utilities\TimeStepType;
use App\Utilities\TimeFilter;

class ActivityController extends Controller
{

    public function index(Request $request)
    {
        $startDate = null;
        $endDate = null;
        $noOfSteps = $request->noOfSteps ? $request->noOfSteps - 1 : 6;
        $stepType = $request->stepType ? $request->stepType : TimeStepType::MONTHLY;
        $filterData = null;

        //Fetch Data
        try {
            $filterData = TimeFilter::get($request->endDate, $request->startDate, $noOfSteps, $stepType);
        } catch (TimeFilterException $e) {
            return back()->with("error", $e->getMessage());
        }


        // Localize data
        $startDate = $filterData->startDate;
        $endDate = $filterData->endDate;
        $stepType = $filterData->stepType;
        $noOfSteps = $filterData->noOfSteps;



        $warehouses = Warehouse::orderBy('location')->get();
        $riders = Rider::orderBy('firstName')->get();

        $totalCarePacks = 0;

        $warehouses->each(function ($warehouse) use (&$totalCarePacks, &$endDate) {
            $totalCarePacks += $warehouse->getNumberOfCarePacksBeforeAndAt($endDate);
        });

        $packRequests = PackRequest::whereHas('warehouse')
            ->with('warehouse')
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->simplePaginate(20, ['*'], 'pack_requests_page');

        $packsReceived = Pack::whereHas('warehouse')
            ->with('warehouse')
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->simplePaginate(20, ['*'], 'pack_received_page');

        $packTransfers = PackTransfer::whereHas('warehouseFrom')
            ->whereHas('warehouseTo')
            ->whereHas('rider')
            ->whereDate('created_at', '<=', $endDate)
            ->with('warehouseFrom', 'warehouseTo', 'rider')
            ->latest()
            ->simplePaginate(20, ['*'], 'pack_transfer_page');


        // $warehousesWithTrashed = Warehouse::withTrashed()->get();
        $warehousesWithTrashed = Warehouse::get();


        //Input / Output Data
        $inputOutputData = [
            'input' => [],
            'output' => [],
            'total' => [],
            'months' => [],
            'warehouses' => []
        ];

        $date = Carbon::create((string) $endDate)->startOfDay();

        for ($i = 0; $i < $noOfSteps; $i++) {
            $i_value = 0;
            $o_value = 0;

            foreach ($warehousesWithTrashed as $key => $warehouse) {
                $w_i =  $warehouse->getNoOfCarePacksInput($date);
                $w_o = $warehouse->getNoOfCarePacksOutput($date);

                $inputOutputData['warehouses'][$key] = $inputOutputData['warehouses'][$key] ?? [
                    'input' => [],
                    'output' => [],
                    'total' => [],
                    'location' => $warehouse->location
                ];

                array_unshift($inputOutputData['warehouses'][$key]['input'], $w_i);
                array_unshift($inputOutputData['warehouses'][$key]['output'], $w_o);
                array_unshift($inputOutputData['warehouses'][$key]['total'], $w_i - $w_o);

                $i_value += $w_i;
                $o_value += $w_o;
            }

            array_unshift($inputOutputData['input'], $i_value);
            array_unshift($inputOutputData['output'], $o_value);
            array_unshift($inputOutputData['total'], $i_value - $o_value);

            switch ($stepType) {
                case TimeStepType::DAILY:
                    array_unshift($inputOutputData['months'], $date->isoFormat('dddd'));
                    $date->subDays(1);
                    break;
                case TimeStepType::WEEKLY:
                    array_unshift($inputOutputData['months'], $i + 1);
                    $date->subWeeks(1);
                    break;
                case TimeStepType::MONTHLY:
                    array_unshift($inputOutputData['months'], $date->format('M'));
                    $date->subMonths(1);
                    break;
                case TimeStepType::YEARLY:
                    array_unshift($inputOutputData['months'], $date->format("Y"));
                    $date->subYears(1);
                    break;
            }
        }

        $monthlyChartData = [
            'months' => $inputOutputData['months'],
            'values' => []
        ];

        for ($i = 0; $i < count($monthlyChartData['months']); $i++) {
            $monthlyChartData["values"][] = $inputOutputData['input'][$i] - $inputOutputData['output'][$i];
        }


        return view('pages.inventory.inventory_activity', compact(
            'totalCarePacks',
            'warehouses',
            'riders',
            'packRequests',
            'packsReceived',
            'packTransfers',
            'monthlyChartData',
            'inputOutputData',
            'endDate',
            'stepType',
        ));
    } //end method index
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2()
    {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(20);
        // Total revenue for care pack
        $totalAmounts = Inventory::all()
            ->sum('amount');
        // Total number of care pack orders
        $totalOrders = Inventory::all()
            ->count();

        $lekki = Warehouse::where('location', 'lekki')->firstOrFail();
        $lekki_id = $lekki->id;

        $ikeja = Warehouse::where('location', 'ikeja')->firstOrFail();
        $ikeja_id = $ikeja->id;

        $ogba = Warehouse::where('location', 'ogba')->firstOrFail();
        $ogba_id = $ogba->id;
        // Total number of items in the inventory (pack).

        $totalPacksLekki = Pack::where('warehouse_id', $lekki_id)
            ->count();

        $totalPacksIkeja = Pack::where('warehouse_id', $ikeja_id)
            ->count();

        $totalPacksOgba = Pack::where('warehouse_id', $ogba_id)
            ->count();
        /**
         * We want to get total care pack for lekki and other locations
         * We are going to sum all received,
         * sum all transfer and order received from this location,
         * then substract both sums.
         */
        $carePack = Pack::where('name', 'care pack')->firstOrFail();
        $carepackId = $carePack->id;


        // Care pack transfer to lekki
        $transferToLekki = Activity::where('pack_id', $carepackId)->where('transferTo_id', $lekki_id)->sum('quantity');
        // Total care pack for lekki in pack table
        $carePackForLekki = Pack::where('name', 'care pack')->where('warehouse_id', $lekki_id)->sum('quantity');
        // Add both To and For lekki
        $toAndForLekki = $transferToLekki + $carePackForLekki;

        // care pack transfer from lekki
        $transferFromLekki = Activity::where('pack_id', $carepackId)->where('transferFrom_id', $lekki_id)->sum('quantity');
        // Order received by lekki
        $orderLekki = Inventory::where('warehouse_id', $lekki_id)->where('is_assigned', 1)->where('is_delivered', 1)->sum('quantity');
        // Add transfer and order lekki
        $lekkiAdd = $transferFromLekki + $orderLekki;
        // Total care pack for lekki
        $carePackLekki = $toAndForLekki - $lekkiAdd;

        // Care pack transfer to ikeja
        $transferToIkeja = Activity::where('pack_id', $carepackId)->where('transferTo_id', $ikeja_id)->sum('quantity');
        // Total care pack for ikeja in pack table
        $carePackForIkeja = Pack::where('name', 'care pack')->where('warehouse_id', $ikeja_id)->sum('quantity');
        // Add both To and For Ikeja
        $toAndForIkeja = $transferToIkeja + $carePackForIkeja;

        // care pack transfer from ikeja
        $transferFromIkeja = Activity::where('pack_id', $carepackId)->where('transferFrom_id', $ikeja_id)->sum('quantity');
        // Order received by ikeja
        $orderIkeja = Inventory::where('warehouse_id', $ikeja_id)->where('is_assigned', 1)->where('is_delivered', 1)->sum('quantity');
        // Add transfer and order ikeja
        $ikejaAdd = $transferFromIkeja + $orderIkeja;
        // Total care pack for ikeja
        $carePackIkeja = $toAndForIkeja - $ikejaAdd;

        // Care pack transfer to ogba
        $transferToOgba = Activity::where('pack_id', $carepackId)->where('transferTo_id', $ogba_id)->sum('quantity');
        // Total care pack for Ogba in pack table
        $carePackForOgba = Pack::where('name', 'care pack')->where('warehouse_id', $ogba_id)->sum('quantity');
        // Add both To and For Ogba
        $toAndForOgba = $transferToOgba + $carePackForOgba;

        // care pack transfer from ogba
        $transferFromOgba = Activity::where('pack_id', $carepackId)->where('transferFrom_id', $ogba_id)->sum('quantity');
        // Order received by ogba
        $orderOgba = Inventory::where('warehouse_id', $ogba_id)->where('is_assigned', 1)->where('is_delivered', 1)->sum('quantity');
        // Add transfer and order ogba
        $ogbaAdd = $transferFromOgba + $orderOgba;
        // Total care pack for ogba
        $carePackOgba = $toAndForOgba - $ogbaAdd;

        $items = Item::all();
        $warehouses = Warehouse::all();
        $categories = Category::all();

        $riders = Rider::all();

        return view('pages.inventory.inventory_activity', compact(['riders', $riders, 'activities', $activities, 'totalAmounts', $totalAmounts, 'totalOrders', $totalOrders, 'carePackLekki', $carePackLekki, 'carePackIkeja', $carePackIkeja, 'carePackOgba', $carePackOgba, 'items', $items, 'categories', $categories, 'warehouses', $warehouses, 'totalPacksLekki', $totalPacksLekki, 'totalPacksIkeja', $totalPacksIkeja, 'totalPacksOgba', $totalPacksOgba]));
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
            'status' => 'required',
            'numberOfItem' => 'required|numeric',
            'receivedFrom' => 'required',
            'collectedBy' => 'required',
            'transferFrom' => 'required',
            'transferTo' => 'required',
            'reason' => 'required',
        ]);

        $item = $request->item;
        $status = $request->status;
        $receivedFrom = $request->receivedFrom;
        $collectedBy = $request->collectedBy;
        $transferFrom = $request->transferFrom;
        $transferTo = $request->transferTo;
        $numberOfItem = $request->numberOfItem;
        $reason = $request->reason;
        if ($transferFrom === $transferTo) {
            return back()->with('error', ' You cannot transfer care packs from and to your warehouse');
        }
        try {
            //code...
            $locationA = Warehouse::where('location', $transferFrom)->firstOrFail(); // Warehouse transfering from
            $locationB = Warehouse::where('location', $transferTo)->firstOrFail(); // Warehouse transfering to

            // Collect IDs
            $locationA_id = $locationA->id;
            $locationB_id = $locationB->id;
            // Pack
            $pack = Pack::where('name', $item)->firstOrFail();
            $pack_id = $pack->id;
            // Total items in a warehouse
            $itemsReceived = Activity::where('pack_id', $pack_id)->where('transferTo_id', $locationA_id)->sum('quantity'); // If this warehouse as received any items before
            $itemsInStore = Pack::where('name', 'care pack')->where('warehouse_id', $locationA_id)->sum('quantity'); // Total carepack in store
            $totalItems = $itemsReceived + $itemsInStore;

            if ($totalItems < $numberOfItem) {
                return back()->with('error', ' ' . $transferFrom . ' does not have enough care packs to perform this action!');
            } else {
                try {
                    //code...
                    $activity = new Activity();
                    $activity->uuid = Uuid::uuid4();
                    $activity->user_id = auth()->user()->id;
                    $activity->pack_id = $pack_id;
                    $activity->quantity = $numberOfItem;
                    $activity->transferFrom_id = $locationA_id;
                    $activity->transferTo_id = $locationB_id;
                    $activity->receivedFrom = $receivedFrom;
                    $activity->collectedBy = $collectedBy;
                    $activity->status = $status;
                    $activity->reason = $reason;
                    $activity->save();
                    return back()->with('success', 'Item updated successfully');
                } catch (\Throwable $th) {
                    throw $th;
                    // return redirect()->back()->with(['error' => 'Internal server error']);
                }
            }
        } catch (\Throwable $th) {
            throw $th;
            // return redirect()->back()->with(['error' => 'Internal server error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        //code...
        $activity = Activity::where('uuid', $uuid)->first();
        return view('pages.inventory.activity_details')->with('activity', $activity);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
