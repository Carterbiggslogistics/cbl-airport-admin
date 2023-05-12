<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PackInfoTemplateExport implements FromView
{
    public function view(): View
    {
        return view("exports.pack_info_template_export");
    } //end method view
}//end class PackInfoTemplateExport
