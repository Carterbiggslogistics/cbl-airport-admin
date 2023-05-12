<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OxygenAddRequest extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function plant()
    {
        return $this->belongsTo(OxygenPlant::class, 'oxygen_plant_id');
    } //end method plant

    public function size()
    {
        return $this->belongsTo(OxygenSize::class, 'oxygen_size_id');
    } //end method size
}//end class OxygenAddRequest
