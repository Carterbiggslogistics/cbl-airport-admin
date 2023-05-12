<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Order;
use Ramsey\Uuid\Uuid;
use App\User;
use App\Lab;
use App\Rider;
use Carbon\Carbon;

class OrderImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $user = User::findOrFail($row['users_id']);

        // if ($user == null)
        //     return null;

        $lab = Lab::findOrFail($row['labs_id']);
        // if ($lab == null)
        //     return null;

        $rider = Rider::findOrFail($row['labs_id']);
        // if ($rider == null)
        //     return null;



        $order = new Order();
        $order->uuid = Uuid::uuid4();
        $order->user_id = $user->id;
        $order->rider_id = $rider->id;
        $order->lab_id = $lab->id;
        $order->pickupRegion = $row['pickup_region'];
        $order->pickupAddress = $row['pickup_address'];
        $order->deliveryRegion = $lab->region;
        $order->deliveryAddress = $lab->address;
        $order->deliveryContactName = $lab->fullname;
        $order->deliveryContactPhone = $lab->phoneNumber;
        $order->quantity = $row['quantity'];
        $order->status = "COMPLETED";
        $order->is_assigned = 1;
        $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["date"]));

        $order->created_at = $date;
        $order->updated_at = $date;

        return $order;
    }
}
