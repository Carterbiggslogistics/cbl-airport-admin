<?php

namespace App\Imports;

use App\Flight;
use Ramsey\Uuid\Uuid;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FlightsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        if (!count($row)) {
            return null;
        }

        return new Flight([
            'uuid' => Uuid::uuid4(),
            'user_id' => Auth::user()->id,
            'passengerName'     => $row['passengername'],
            'passengerEmail'    => $row['passengeremail'],
            'passengerPhone' => $row['passengerphone'],
            'passportNumber' => $row['passportnumber'],
            'airport' => $row['airport'],
            'airline' => $row['airline'],
            'time' => $row['time'],
            'origin' => $row['origin'],
            'paymentType' => $row['paymenttype'],
            'amount' => $row['amount'],
            'dateOfArrival' => $row['dateofarrival'],
        ]);
    }
}
