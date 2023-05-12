<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Access\Gate;

use App\OxygenRequest;
use App\OxygenSize;
use App\OxygenPlant;
use App\OxygenAddRequest;
use Carbon\Carbon;
use App\Exceptions\TimeFilterException;
use App\PackRequest;
use App\Utilities\TimeStepType;
use App\Utilities\TimeFilter;
use DB;


class OxygenInventoryController extends Controller
{
    public function __contruct(Gate $gate)
    {
        $gate->define('access-oxygen-plant-controller', fn ($user) => $user->can('isSuperAdmin') || $user->can('oxygen-admin'));

        $this->middleware('can:access-oxygen-plant-controller');
    } //end contructor method


    public function index(Request $request)
    {

        $startDate = null;
        $endDate = null;
        $noOfSteps = $request->noOfSteps ? $request->noOfSteps - 1 : 10;
        $stepType = $request->stepType ? $request->stepType : TimeStepType::DAILY;
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

        $plants = OxygenPlant::with('oxygenRequests')->get();
        $cylinderSizes = OxygenSize::all();

        $oxygenRequestsData = [
            'total' => 0,
            'supply_requests' => OxygenRequest::where(
                [
                    ['created_at', '>=', $request->startDate ? $startDate->copy()->startOfDay() : now()->startOfDay()],
                    ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()]
                ]
            )->count(),
            'days' => [],
            'values' => [],
            'pickupValues' => [],
            'total_past_week' => OxygenRequest::where(
                [
                    ['created_at', '>=', $request->startDate ? $startDate->copy()->startOfDay() : now()->startOfDay()],
                    ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()]
                ]
            )
                ->count(),
            'lastMonth' => OxygenRequest::where([
                ['created_at', '>', Carbon::create((string) $endDate)->startOfDay()->subMonths(1)],
                ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()],
            ])->count(),
            'today' => OxygenRequest::whereDate('created_at', $endDate)->count(),
            'plants' => [],
        ];




        $date = Carbon::create((string) $endDate)->startOfDay();
        for ($i = 0; $i < $noOfSteps; $i++) {
            //Calculate plant request details for each plant
            for ($j = 0; $j < count($plants); $j++) {
                $plant = $plants[$j];

                $oxygenRequestsData['plants'][$j] = $oxygenRequestsData['plants'][$j] ?? [
                    'values' => [],
                    'cylValues' => [],
                    'name' => $plant->name,
                    'id' => $plant->id,
                ];

                $builder = null;

                switch ($stepType) {
                    case TimeStepType::DAILY:
                        $builder = $plant->oxygenRequests()->whereDate('oxygen_requests.created_at', $date);
                        break;
                    case TimeStepType::WEEKLY:
                        $builder = $plant->oxygenRequests()->where([
                            ['oxygen_requests.created_at', ">=", $date->copy()->startOfWeek()],
                            ['oxygen_requests.created_at', "<", $date->copy()->startOfWeek()->addWeeks(1)]
                        ]);
                        break;
                    case TimeStepType::MONTHLY:
                        $builder = $plant->oxygenRequests()->where([
                            ['oxygen_requests.created_at', ">=", $date->copy()->startOfMonth()],
                            ['oxygen_requests.created_at', "<", $date->copy()->startOfMonth()->addMonths(1)]
                        ]);
                        break;
                    case TimeStepType::YEARLY:
                        $builder = $plant->oxygenRequests()->where([
                            ['oxygen_requests.created_at', ">=", $date->copy()->startOfYear()],
                            ['oxygen_requests.created_at', "<", $date->copy()->startOfYear()->addYears(1)]
                        ]);
                        break;
                }

                $cylVal = 0;
                $builder->get()->each(function ($request) use (&$cylVal) {
                    $cylVal += $request->noOfCylinders;
                });
                array_unshift($oxygenRequestsData['plants'][$j]['values'], $builder->count());
                array_unshift($oxygenRequestsData['plants'][$j]['cylValues'], $cylVal);
            }

            switch ($stepType) {
                case TimeStepType::DAILY:
                    $date->startOfDay();
                    $t_orders = OxygenRequest::whereDate('created_at',  $date)->count();
                    array_unshift($oxygenRequestsData['days'], $date->isoFormat('dddd'));
                    $date->subDays(1);
                    break;
                case TimeStepType::WEEKLY:
                    $date->startOfWeek();
                    $t_orders = OxygenRequest::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addWeeks(1)]
                    ])->count();
                    array_unshift($oxygenRequestsData['days'], $i + 1);
                    $date->subWeeks(1);
                    break;
                case TimeStepType::MONTHLY:
                    $date->startOfMonth();
                    $t_orders = OxygenRequest::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addMonths(1)]
                    ])->count();
                    array_unshift($oxygenRequestsData['days'], $date->format("M"));
                    $date->subMonths(1);
                    break;
                case TimeStepType::YEARLY:
                    $date->startOfYear();
                    $t_orders = OxygenRequest::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addYears(1)]
                    ])->count();
                    array_unshift($oxygenRequestsData['days'], $date->format("Y"));
                    $date->subYears(1);
                    break;
            }

            array_unshift($oxygenRequestsData['values'], $t_orders);
        }

        //==================================================================================
        //=============Cylinders
        //==================================================================================

        $cylindersData = [
            'xMarkers' => [],
            'sent' => [],
            'pickedUp' => [],
            "net" => [],
            'pendingCylinders' => 0,
            'total' => 0,
            'plants' => []
        ];

        //Calculate total Cylinders


        $plants->each(function ($plant) use (&$cylindersData, &$cylinderSizes) {
            $cylindersData['total'] += $plant->totalNoOfCylinders;
            $sizes = [];

            foreach ($cylinderSizes as $cSize) {
                $sizes[] = [
                    'size' => $cSize->size,
                    'count' => $plant->getNoOfCylindersFromSize($cSize),
                ];
            }
            //Oxygen plants cylinder info
            $cylindersData['plants'][] = [
                'name' => $plant->name,
                'sizes' => $sizes,
                'total' => $plant->totalNoOfCylinders
            ];
        });

        $pendingRequests = OxygenRequest::where([
            ['status', "<>", OxygenRequest::STATUS['PICKED-UP']],
            ['created_at', "<=", $endDate->copy()->endOfDay()]
        ])->get();

        $totalPendingCylinders = 0;

        $pendingRequests->each(function ($oR) use (&$totalPendingCylinders) {
            $totalPendingCylinders += $oR->noOfCylinders;
        });

        $cylindersData['pendingCylinders'] =  $totalPendingCylinders;

        $date = Carbon::create((string) $endDate)->startOfDay();

        for ($i = 0; $i < $noOfSteps; $i++) {
            $o = [];
            $p = [];

            switch ($stepType) {
                case TimeStepType::DAILY:
                    $date->startOfDay();
                    $o = OxygenRequest::where([
                        ['created_at', '<=', $date->copy()->endOfDay()]
                    ])->get();
                    $p = OxygenRequest::where([
                        ['status', OxygenRequest::STATUS["PICKED-UP"]],
                        ['pickupDate', '<=', $date->copy()->endOfDay()]
                    ])->get();
                    array_unshift($cylindersData['xMarkers'], $date->isoFormat('dddd'));
                    $date->subDays(1);
                    break;
                case TimeStepType::WEEKLY:
                    $date->startOfWeek();
                    $o = OxygenRequest::where([
                        ['created_at', '<=', $date->copy()->endOfWeek()->endOfDay()]
                    ])->get();
                    $p = OxygenRequest::where([
                        ['status', OxygenRequest::STATUS["PICKED-UP"]],
                        ['pickupDate', '<=', $date->copy()->endOfWeek()->endOfDay()]
                    ])->get();
                    array_unshift($cylindersData['xMarkers'], $i + 1);
                    $date->subWeeks(1);
                    break;
                case TimeStepType::MONTHLY:
                    $date->startOfMonth();
                    $o = OxygenRequest::where([
                        ['created_at', '<=', $date->copy()->endOfMonth()->endOfDay()]
                    ])->get();
                    $p = OxygenRequest::where([
                        ['status', OxygenRequest::STATUS["PICKED-UP"]],
                        ['pickupDate', '<=', $date->copy()->endOfMonth()->endOfDay()]
                    ])->get();
                    array_unshift($cylindersData['xMarkers'], $date->format("M"));
                    $date->subMonths(1);
                    break;
                case TimeStepType::YEARLY:
                    $date->startOfYear();
                    $o = OxygenRequest::where([
                        ['created_at', '<=', $date->copy()->endOfYear()->endOfDay()]
                    ])->get();
                    $p = OxygenRequest::where([
                        ['status', OxygenRequest::STATUS["PICKED-UP"]],
                        ['pickupDate', '<=', $date->copy()->endOfYear()->endOfDay()]
                    ])->get();
                    array_unshift($cylindersData['xMarkers'], $date->format("Y"));
                    $date->subYears(1);
                    break;
            }

            $t = 0;
            $t_p = 0;

            $o->each(function ($oR) use (&$t) {
                $t += $oR->noOfCylinders;
            });

            $p->each(function ($oR) use (&$t_p) {
                $t_p += $oR->noOfCylinders;
            });

            array_unshift($cylindersData['xMarkers'], $date->isoFormat('dddd'));
            array_unshift($cylindersData['sent'], $t);
            array_unshift($cylindersData['pickedUp'], $t_p);
            array_unshift($cylindersData['net'], $t - $t_p);
        }

        //============================================================================
        //===Oxygen request table data
        //===========================================================================
        $oxygenRequestsQuery = OxygenRequest::with(
            'client',
            'plant'
        )->latest();

        $oxygenRequests = $oxygenRequestsQuery->simplePaginate(15, ['*'], 'oxygen_requests');

        // dd($oxygenRequestsData);

        // dd($cylindersData);

        $addRequests = OxygenAddRequest::latest()->simplePaginate(15, ['*'], 'oxygen_add_requests');

        //=============================================================================
        //=== Region Data
        //=============================================================================

        $regionResult = OxygenRequest::with('plant')
            ->groupBy('oxygen_plant_id')
            ->select('oxygen_plant_id', DB::raw('count(*) as count'))->orderBy('count', 'desc')
            ->where('created_at', "<=", $endDate->copy()->endOfDay())
            ->take(10)
            ->get();

        $regionData = [
            'yMarkers' => $regionResult->pluck('count')->toArray(),
            'xMarkers' => $regionResult->pluck('plant.name')->toArray(),
        ];

        return view('pages.oxygen.overview', compact(
            'oxygenRequestsData',
            'cylindersData',
            'oxygenRequests',
            'addRequests',
            'regionData'
        ));
    } //end method index

    public function addActions(Request $request)
    {
        $plants = OxygenPlant::all();
        $sizes = OxygenSize::all();
        $addRequests = OxygenAddRequest::latest()->simplePaginate(20);

        return view("pages.oxygen.add_actions", compact(
            'plants',
            'sizes',
            'addRequests'
        ));
    } //end method addActions
}//end class OxygenOverviewController
