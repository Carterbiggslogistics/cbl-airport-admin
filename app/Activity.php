<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes;

    public function pack()
    {
        return $this->belongsTo(Pack::class, 'pack_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transferFrom()
    {
        return $this->belongsTo(Warehouse::class, 'transferFrom_id');
    }

    public function transferTo()
    {
        return $this->belongsTo(Warehouse::class, 'transferTo_id');
    }
}
