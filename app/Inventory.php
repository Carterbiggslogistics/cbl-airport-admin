<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    const STATUS = [
        'DELIVERED' => 'DELIVERED',
        'RELEASED' => 'RELEASED'
    ];

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'pack_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
