<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OxygenSize extends Model
{
    use SoftDeletes;

    protected $guarded = [];
}//end class OxygenSize
