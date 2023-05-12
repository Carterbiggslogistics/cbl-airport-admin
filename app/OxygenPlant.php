<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OxygenPlant extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function oxygenRequests()
    {
        return $this->hasMany(OxygenRequest::class, 'oxygen_plant_id');
    } //end method oxygenRequests

    public function requestsNotPicked()
    {
        return $this->oxygenRequests()->where('status', '<>', OxygenRequest::STATUS['PICKED-UP']);
    } //end method requestsNotPicked

    public function requestsPicked()
    {
        return $this->oxygenRequests()->where('status', OxygenRequest::STATUS['PICKED-UP']);
    } //end method requestsPicked

    public function addRequests()
    {
        return $this->hasMany(OxygenAddRequest::class, 'oxygen_plant_id');
    } //end metho  addRequests

    public function getTotalNoOfCylindersAttribute()
    {
        $nRequestsPicked = 0;
        $this->requestsPicked->each(function ($request) use (&$nRequestsPicked) {
            $nRequestsPicked += $request->noOfCylinders;
        });

        $nRequests = 0;
        $this->oxygenRequests->each(function ($request) use (&$nRequests) {
            $nRequests += $request->noOfCylinders;
        });

        $nAddRequests = $this->addRequests->sum('count');

        return $nAddRequests + $nRequestsPicked - $nRequests;
    } //end method getTotalNoOfCylindersAttribute

    public function getNoOfCylindersFromSize(OxygenSize $oxygenSize)
    {
        $nRequestsPicked = 0;
        $this->requestsPicked()->with(['supplies' => function ($query) use ($oxygenSize) {
            $query->where('oxygen_supplies.oxygen_size_id', $oxygenSize->id);
        }])->get()->each(function ($request) use (&$nRequestsPicked) {
            foreach ($request->supplies as $supply) {
                $nRequestsPicked += $supply->noOfCylinders;
            }
        });

        $nRequests = 0;
        $this->oxygenRequests()->with(['supplies' => function ($query) use ($oxygenSize) {
            $query->where('oxygen_supplies.oxygen_size_id', $oxygenSize->id);
        }])->get()->each(function ($request) use (&$nRequests) {
            foreach ($request->supplies as $supply) {
                $nRequests += $supply->noOfCylinders;
            }
        });

        $nAddRequests = $this->addRequests()->where('oxygen_size_id', $oxygenSize->id)->sum('count');

        return $nAddRequests + $nRequestsPicked - $nRequests;
    } //end method getNoOfCylindersFromSize
}//end class OxygenPlant
