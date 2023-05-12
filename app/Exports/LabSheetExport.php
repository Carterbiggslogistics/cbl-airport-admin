<?php

namespace App\Exports;

use App\Lab;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LabSheetExport implements FromView
{
    public function view(): View
    {
        return view("exports.lab_sheet_export", [
            'labs' => Lab::all()
        ]);
    } //end method view
}
