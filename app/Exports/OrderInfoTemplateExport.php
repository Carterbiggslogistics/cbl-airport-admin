<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderInfoTemplateExport implements FromView
{
    public function view(): View
    {
        return view("exports.order_info_template_export");
    } //end method view
}//end class OrderInfoTemplateExport
