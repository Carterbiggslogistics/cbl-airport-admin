<?php

namespace App\Http\Controllers;

use App\Exceptions\TimeFilterException;
use App\Order;
use App\Lab;
use App\User;
use App\Role;
use App\Transaction;
use App\Inventory;
use App\Warehouse;
use App\Flight;
use App\Utilities\TimeStepType;
use App\Utilities\TimeFilter;
use App\PackRequest;
use Illuminate\Support\Facades\DB;
use Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = null;
        $endDate = null;
        $noOfSteps = $request->noOfSteps ? $request->noOfSteps - 1 : 6;
        $stepType = $request->stepType ? $request->stepType : TimeStepType::DAILY;
        $filterData = null;

        //Fetch Data
        try {
            $filterData = TimeFilter::get($request->endDate, $request->startDate, $noOfSteps, $stepType);
        } catch (TimeFilterException $e) {
            return back()->with("error", $e->getMessage());
        }


        // Localize data
        $startDate = Carbon::create((string) $filterData->startDate);
        $endDate = Carbon::create((string) $filterData->endDate);
        $stepType = $filterData->stepType;
        $noOfSteps = $filterData->noOfSteps < 7 ? 7 : $filterData->noOfSteps;



        $noOfSampleRequests = Order::where([
            ['created_at', '>=', $request->startDate ? $startDate->copy()->startOfDay() : now()->startOfDay()],
            ['created_at', '<=', $endDate->copy()->endOfDay()]
        ])->sum('quantity');
        $noOfPackRequests = PackRequest::where([
            ['created_at', '>=', $request->startDate ? $startDate->copy()->startOfDay() : now()->startOfDay()],
            ['created_at', '<=', $endDate->copy()->endOfDay()]
        ])->sum('quantity');
        $warehouses = Warehouse::all();

        //Calculate Total carepacks
        $totalCarePacks = 0;
        $warehouses->each(function ($warehouse) use (&$totalCarePacks, &$endDate) {
            $totalCarePacks += $warehouse->getNumberOfCarePacksBeforeAndAt($endDate);
        });


        //No of flights
        $noOfFlights = Flight::where([
            ['created_at', '>=', $request->startDate ? $startDate->startOfDay() : now()->startOfDay()],
            ['created_at', '<=', $endDate->endOfDay()]
        ])->count();


        //============================================================================
        //===Orders Data
        //============================================================================
        $ordersData = [
            'days' => [],
            'values' => [],
            'today' => Order::whereDate('created_at', Carbon::create((string) $endDate))->sum('quantity'),
            'total' => Order::where(
                [
                    ['created_at', '>=', Carbon::create((string) $startDate)->startOfDay()],
                    ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()]
                ]
            )
                ->sum('quantity'),
            'lastMonth' => Order::where([
                ['created_at', '>', Carbon::create((string) $endDate)->startOfDay()->subMonths(1)],
                ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()],
            ])->sum('quantity'),
        ];

        $date = Carbon::create((string) $endDate)->startOfDay();

        for ($i = 0; $i < $noOfSteps; $i++) {
            $t_orders = null;

            switch ($stepType) {
                case TimeStepType::DAILY:
                    $t_orders = Order::whereDate('created_at',  $date)->sum('quantity');
                    array_unshift($ordersData['days'], $date->isoFormat('dddd'));
                    $date->subDays(1);
                    break;
                case TimeStepType::WEEKLY:
                    $date->startOfWeek();
                    $t_orders = Order::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addWeeks(1)]
                    ])->sum('quantity');
                    array_unshift($ordersData['days'], $i + 1);
                    $date->subWeeks(1);
                    break;
                case TimeStepType::MONTHLY:
                    $date->startOfMonth();
                    $t_orders = Order::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addMonths(1)]
                    ])->sum('quantity');
                    array_unshift($ordersData['days'], $date->format("M"));
                    $date->subMonths(1);
                    break;
                case TimeStepType::YEARLY:
                    $date->startOfYear();
                    $t_orders = Order::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addYears(1)]
                    ])->sum('quantity');
                    array_unshift($ordersData['days'], $date->format("Y"));
                    $date->subYears(1);
                    break;
            }

            array_unshift($ordersData['values'], (float) $t_orders);
        }


        //============================================================================
        //===Passengers recorded data
        //============================================================================
        $passengersRecordedData = [
            'days' => [],
            'values' => []
        ];
        $date = Carbon::create((string) $endDate)->startOfDay();

        for ($i = 0; $i < $noOfSteps; $i++) {
            $t_orders = null;

            switch ($stepType) {
                case TimeStepType::DAILY:
                    $t_orders = Flight::whereDate('created_at',  $date)->count();
                    array_unshift($passengersRecordedData['days'], $date->isoFormat('dddd'));
                    $date->subDays(1);
                    break;
                case TimeStepType::WEEKLY:
                    $date->startOfWeek();
                    $t_orders = Flight::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addWeeks(1)]
                    ])->count();
                    array_unshift($passengersRecordedData['days'], $i + 1);
                    $date->subWeeks(1);
                    break;
                case TimeStepType::MONTHLY:
                    $date->startOfMonth();
                    $t_orders = Flight::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addMonths(1)]
                    ])->count();
                    array_unshift($passengersRecordedData['days'], $date->format("M"));
                    $date->subMonths(1);
                    break;
                case TimeStepType::YEARLY:
                    $date->startOfYear();
                    $t_orders = Flight::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addYears(1)]
                    ])->count();
                    array_unshift($passengersRecordedData['days'], $date->format("Y"));
                    $date->subYears(1);
                    break;
            }

            array_unshift($passengersRecordedData['values'], (float) $t_orders);
        }

        //============================================================================
        //===Care Packs Data
        //============================================================================
        $carePacksData = [
            'days' => [],
            'values' => [],
            'today' => PackRequest::whereDate('created_at', now())->sum('quantity'),
            'total' => PackRequest::where(
                [
                    ['created_at', '>=', Carbon::create((string) $startDate)->startOfDay()],
                    ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()]
                ]
            )
                ->sum('quantity'),
            'lastMonth' => PackRequest::where([
                ['created_at', '>', Carbon::create((string) $endDate)->startOfDay()->subMonths(1)],
                ['created_at', '<=', Carbon::create((string) $endDate)->endOfDay()],
            ])->sum('quantity'),
        ];

        $date = Carbon::create((string) $endDate)->startOfDay();

        for ($i = 0; $i < $noOfSteps; $i++) {
            $t_orders = null;

            switch ($stepType) {
                case TimeStepType::DAILY:
                    $t_orders = PackRequest::whereDate('created_at',  $date)->sum('quantity');
                    array_unshift($carePacksData['days'], $date->isoFormat('dddd'));
                    $date->subDays(1);
                    break;
                case TimeStepType::WEEKLY:
                    $date->startOfWeek();
                    $t_orders = PackRequest::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addWeeks(1)]
                    ])->sum('quantity');
                    array_unshift($carePacksData['days'], $i + 1);
                    $date->subWeeks(1);
                    break;
                case TimeStepType::MONTHLY:
                    $date->startOfMonth();
                    $t_orders = PackRequest::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addMonths(1)]
                    ])->sum('quantity');
                    array_unshift($carePacksData['days'], $date->format("M"));
                    $date->subMonths(1);
                    break;
                case TimeStepType::YEARLY:
                    $date->startOfYear();
                    $t_orders = PackRequest::where([
                        ['created_at', ">=", $date],
                        ['created_at', "<", Carbon::create((string) $date)->addYears(1)]
                    ])->sum('quantity');
                    array_unshift($carePacksData['days'], $date->format("Y"));
                    $date->subYears(1);
                    break;
            }

            array_unshift($carePacksData['values'], (float) $t_orders);
        }

        return view('pages.user.dashboard', compact(
            //new values
            'noOfSampleRequests',
            'noOfPackRequests',
            'totalCarePacks',
            'noOfFlights',
            'ordersData',
            'passengersRecordedData',
            'carePacksData'
        ));
    } //end method index
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index2()
    {
        $request = request();
        $defaultPrevioudDays = 7;

        try {
            $previousDays = (int) $request->previousDays ?? $defaultPrevioudDays;
            $previousDays = $previousDays <= 0 ? $defaultPrevioudDays  : $previousDays;
        } catch (\Throwable $th) {
            $previousDays = $defaultPrevioudDays;
        }

        $date = Carbon::today()->subDays($previousDays);

        // Get pending order for lab
        // $pendingOrdersLab = Role::where('admin', $lab)
        //     ->join('users', 'role_id', 'roles.id')
        //     ->join('orders', 'orders.user_id', 'users.id')
        //     ->where('is_assigned', 0)
        //     ->where('is_completed', 0)
        //     ->get()
        //     ->count();

        // Today transaction
        $transactionsToday = Transaction::whereDate('created_at', Carbon::today())
            ->sum('amount');

        // Monthly transactions
        $monthlyTransactions = Transaction::whereMonth('created_at', Carbon::today())
            ->get()
            ->sum('amount');
        // $monthlyTransactions = Transaction::whereBetween('created_at', [$today->startOfMonth() ,Carbon::today()])->get()->sum('amount');

        // Total transactions
        $totalTransactions = Transaction::all()
            ->sum('amount');

        $totalInventory = DB::table('inventories')->count();
        $totalFlight = DB::table('flights')->count();


        // All orders
        $totalOrders = Order::all()
            ->count();
        // Today orders
        $ordersToday = Order::whereDate('created_at', Carbon::today())->get()->count();
        // Monthly Order
        // $monthlyOrders = Order::whereBetween('created_at', [$today->startOfMonth() ,Carbon::today()])
        // ->get()
        // ->count();
        $monthlyOrders = Order::whereMonth('created_at', Carbon::today())
            ->get()
            ->count();



        //New values for dashboard
        $totalCarePacks = Inventory::whereDate('created_at', '>=', $date)->whereHas('pack', function ($query) {
            $query->where('name', 'care pack');
        })->sum('quantity');


        return view('pages.user.dashboard', [
            'totalOrders' => $totalOrders,
            'totalInventory' => $totalInventory,
            'transactionsToday' => $transactionsToday,
            'totalFlight' => $totalFlight,
            'totalTransactions' => $totalTransactions,
            'monthlyTransactions' => $monthlyTransactions,
            'monthlyOrders' => $monthlyOrders,
            'ordersToday' => $ordersToday,

            //New values for dashboard
            'totalCarePacks' => $totalCarePacks,
        ]);
    }

    /**
     * Lab Dashboard
     * Display everything about lab to the lab admin
     */
    public function myLab()
    {

        $userId = auth()->user()->id;
        $lab = Lab::where('admin_id', $userId)->first();
        $labs = Lab::all();
        return view('pages.user.my_lab', compact(['lab', $lab, 'labs', $labs]));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
