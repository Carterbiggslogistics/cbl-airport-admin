<?php

namespace App\Traits;

use App\UserDevice;

trait Deviceable
{
    public function devices()
    {
        return $this->morphMany(UserDevice::class, "deviceable");
    } //end method devices
}//end interface Deviceable