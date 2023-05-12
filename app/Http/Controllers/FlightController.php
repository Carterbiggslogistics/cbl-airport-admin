<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;
use Auth;
use App\Imports\FlightsImport;
use App\Exports\FlightsExport;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //code...
            $flights = Flight::with(['user' => function ($query) {
                $query->withTrashed();
            }])->orderBy('created_at', 'desc')->paginate(20);

            $flights->each(function ($flight) {
                if (!$flight->user) {
                    $flight['user'] = (object) ['fullname' => 'Deleted User'];
                }
            });
            // dd($flights);
            return view('pages.flight.all_flight', compact(['flights', $flights]));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => 'Internal server error']);
        }
    } //end method index

    public function canceledFlights()
    {
        try {
            //code...
            $flights = Flight::orderBy('updated_at', 'desc')->withTrashed()->with(['user' => function ($query) {
                $query->withTrashed();
            }])->where('canceled', true)->paginate(20);

            $flights->each(function ($flight) {
                if (!$flight->user) {
                    $flight['user'] = (object) ['fullname' => 'Deleted User'];
                }
            });
            // dd($flights);
            return view('pages.flight.canceled_flight', compact(['flights', $flights]));
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => 'Internal server error']);
        }
    } //end method canceledFlights

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guest()) {
            //is a guest so redirect
            return redirect('/auth-login');
        }
        try {
            //code...
            return view('pages.flight.create_flight');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'passengerName' => 'required',
            'passengerEmail' => '',
            'passengerPhone' => 'required|numeric',
            'passportNumber' => 'required',
            'airline' => 'required',
            'airport' => 'required',
            'time' => 'required',
            'origin' => 'required',
            'moment' => 'required',
            'paymentType' => 'required',
            'amount' => 'required',
            'dateOfArrival' => 'required|date',
        ]);

        $passengerName = $request->passengerName;
        $passengerEmail = $request->passengerEmail;
        $passengerPhone = $request->passengerPhone;
        $passportNumber = $request->passportNumber;
        $airline = $request->airline;
        $airport = $request->airport;
        $origin = $request->origin;
        $time = $request->time;
        $moment = $request->moment;
        $paymentType = $request->paymentType;
        $amount = $request->amount;
        $arrival = $time . ' ' . $moment;
        $dateOfArrival = $request->dateOfArrival;
        try {
            //code...
            $newFlight = new Flight();
            $newFlight->uuid = Uuid::uuid4();
            $newFlight->user_id = Auth::user()->id;
            $newFlight->passengerName = $passengerName;
            $newFlight->passengerEmail = $passengerEmail;
            $newFlight->passengerPhone = $passengerPhone;
            $newFlight->passportNumber = $passportNumber;
            $newFlight->airline = $airline;
            $newFlight->airport = $airport;
            $newFlight->time = $arrival;
            $newFlight->origin = $origin;
            $newFlight->amount = $amount;
            $newFlight->paymentType = $paymentType;
            $newFlight->dateOfArrival = $dateOfArrival;
            $newFlight->save();
            return redirect('/all-flights')->with('success', 'Flight Successful!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Flight $flight)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Flight $flight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Flight $flight)
    {
        //
    } //end method update

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flight $flight)
    {
        //
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importFlight(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xlsx',
        ]);

        $file = request()->file('file');
        try {
            //code...
            Excel::import(new FlightsImport, $file);
            return redirect('/all-flights')->with('success', 'Flight Successful!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function exportFlight()
    {
        return Excel::download(new FlightsExport, 'flights.xlsx');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function downloadTemplate()
    {
        return response()->download(public_path('assets/mmia_transaction_upload_template.xlsx'));
    }

    /**
     * Filter by date
     */
    public function search(Request $request)
    {
        $this->validate($request, [
            'search' => 'required',
        ]);
        $date = $request->get('date');
        try {
            //code...
            $flights = Flight::whereDate('created_at', $date)
                ->orderBy("created_at", 'desc')
                ->paginate(10);
            return response()->json($flights);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cancelFlight(Request $request)
    {
        $request->validate([
            'id' => 'required|string'
        ]);

        try {
            $flight = Flight::findOrFail($request->id);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with(['error' => 'Unable to cancel flight. Flight not found']);
        }

        $flight->canceled = true;
        $flight->save();

        $flight->delete();
        return back()->with('success', 'Flight successfully canceled');
    } //end method cancelFlight
}//end class FlightController
