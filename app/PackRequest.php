<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackRequest extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    const STATUS = [
        'TRANSIT' => "TRANSIT",
        "DELIVERED" => "DELIVERED",
        "PICKED UP" => "PICKED UP",
        "CANCELED" => "CANCELED",
        'RETURNED-ORDER' => 'RETURNED-ORDER',
    ];

    const STATUS_IMAGE_FOLDER_PATH = "pack/statuses";


    public function getRiderNameAttribute()
    {
        return ($this->rider == null
            ? $this->fallbackRiderName :
            $this->rider->fullname) ?? "";
    } //end method getRiderNameAttribute


    public function rider()
    {
        return $this->belongsTo(Rider::class);
    } //end method rider


    public function getWarehouseLocationAttribute()
    {
        return ($this->warehouse == null
            ? $this->fallbackWarehouseLocation :
            $this->warehouse->location) ?? "";
    } //end method getRiderNameAttribute

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    } //end method warehouse

    public function getRequestedByAttribute()
    {
        return $this->user->fullname;
    } //end method getRequestedByAttribute

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end method user
}//end PackRequest
