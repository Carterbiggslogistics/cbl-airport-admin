<?php

namespace App\Exports;

use App\Warehouse;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class WarehouseSheetExport implements FromView
{
    public function view():View
    {
        return view("exports.warehouse_sheet_export", [
            'warehouses' => Warehouse::all()
        ]);
    }//end method view
}
