<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Lab extends Model
{
    use SoftDeletes;
    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}