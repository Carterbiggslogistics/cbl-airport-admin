<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
