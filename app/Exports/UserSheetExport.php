<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserSheetExport implements FromView
{
    public function view(): View
    {
        return view("exports.user_sheet_export", [
            'users' => User::all()
        ]);
    } //end method view
}
