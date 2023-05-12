<?php

namespace App\Exports;

use App\Rider;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RiderSheetExport implements FromView
{
    public function view():View
    {
        return view("exports.rider_sheet_export", [
            'riders' => Rider::all()
        ]);
    }//end method view
}
