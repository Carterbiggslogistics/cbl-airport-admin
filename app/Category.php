<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    // Pack class
    public function pack()
    {
        return $this->hasOne(Pack::class);
    }
}
