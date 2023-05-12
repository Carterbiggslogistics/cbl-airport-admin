<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OxygenSupply extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(OxygenRequest::class, 'oxygen_request_id');
    } //end method request

    public function size()
    {
        return $this->belongsTo(OxygenSize::class, 'oxygen_size_id');
    } //end method size
}//end class OxygenSupply
