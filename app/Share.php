<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Share extends Model
{
    use SoftDeletes;

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }

    public function user()
    {
        return $this->belongsTo(Rider::class, 'user_id');
    }

    public function labA()
    {
        return $this->belongsTo(Lab::class, 'labA_id');
    }

    public function labB()
    {
        return $this->belongsTo(Lab::class, 'labB_id');
    }
}