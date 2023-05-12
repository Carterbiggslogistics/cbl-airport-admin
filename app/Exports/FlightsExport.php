<?php

namespace App\Exports;

use App\Flight;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

// use Maatwebsite\Excel\Concerns\FromCollection;

// class FlightsExport implements FromCollection
// {
    /**
    * @return \Illuminate\Support\Collection
    */
//     public function collection()
//     {
//         return Flight::all();
//     }
// }

class FlightsExport implements FromView
{
    public function view(): View
    {
        return view('pages.flight.export', [
            'flights' => Flight::all()
        ]);
    }
}
