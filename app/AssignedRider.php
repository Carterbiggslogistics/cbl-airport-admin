<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignedRider extends Model
{
    public function rider()
    {
        return $this->belongsTo(Order::class, 'rider_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
