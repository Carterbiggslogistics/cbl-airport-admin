<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OxygenRequest extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    const STATUS = [
        'ON-ROUTE' => 'ON-ROUTE',
        'DELIVERED' => 'DELIVERED',
        'PICKED-UP' => 'PICKED-UP'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    } //end method user

    public function client()
    {
        return $this->belongsTo(OxygenClient::class, 'oxygen_client_id');
    } //end method client

    public function supplies()
    {
        return $this->hasMany(OxygenSupply::class);
    } //end method supplies

    public function plant()
    {
        return $this->belongsTo(OxygenPlant::class, 'oxygen_plant_id');
    } //end method plant

    public function getNoOfCylindersAttribute()
    {
        return $this->supplies()->sum('noOfCylinders');
    } //end method getNoOfCylindersAttribute

    public function getTotalVolumeAttribute()
    {
        $rv = 0;

        $this->loadMissing('supplies.size');

        foreach ($this->supplies as $supply) {
            $rv += $supply->size->size * $supply->noOfCylinders;
        }

        return $rv;
    } //end methid getTotalVolumeAttribue
}//end class OxygenRequest
