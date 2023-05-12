<?php

namespace App\Imports;

use App\PackRequest;
use App\Rider;
use App\Warehouse;
use Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class PackImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $requiredCols = [
            "description",
            "delivery_contacts_name",
            "delivery_contacts_phone_number",
            "quantity",
            "pickup_region",
            "pickup_address",
            "delivery_region",
            "delivery_address",
            "warehouses_id",
            "riders_id",
            "order_delivered"
        ];

        //Confirm if the required Cols are intact
        //else return null
        foreach ($requiredCols as $col) {
            if (!$row[$col]) return null;
        }



        $packRequest = new PackRequest();
        $packRequest->quantity = $row["quantity"];
        $packRequest->description = $row["description"];
        $packRequest->pickupRegion = $row["pickup_region"];
        $packRequest->pickupAddress = $row["pickup_address"];
        $packRequest->deliveryRegion = $row["delivery_region"];
        $packRequest->deliveryAddress = $row["delivery_address"];
        $packRequest->deliveryContactName = $row["delivery_contacts_name"];
        $packRequest->deliveryContactPhone = $row["delivery_contacts_phone_number"];

        $packRequest->status = strtolower($row['order_delivered']) == 'yes' ?
            PackRequest::STATUS["DELIVERED"] :
            PackRequest::STATUS["CANCELED"];

        // try {
        $rider = Rider::findOrFail($row["riders_id"]);
        $warehouse = Warehouse::findOrFail($row["warehouses_id"]);
        // } catch (\Throwable $th) {
        //     return null;
        // }

        $packRequest->rider()->associate($rider);
        $packRequest->warehouse()->associate($warehouse);
        $packRequest->user()->associate(auth()->user());



        //Validate date (optional) input
        if ($row['date']) {
            try {
                $date = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["date"]));

                $packRequest->created_at = $date;
                $packRequest->updated_at = $date;
            } catch (\Throwable $th) {
            }
        }

        return $packRequest;
    } //end method model
}//end class PackImport
