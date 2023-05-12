<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Warehouse extends Model
{
    use SoftDeletes;

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function cancelingUser()
    {
        return $this->belongsTo(User::class, 'user_that_cancel_id');
    } //end method cancelingUser

    public function getNoOfCarePacksAttribute()
    {
        return $this->getNumberOfCarePacksBeforeAndAt(now());
    } //end method getNoOfCarePacksAttribute

    public function getNumberOfCarePacksBeforeAndAt($date)
    {
        $totalCarePacksInWarehouse = $this->getNoOfCarePacksInput($date) - $this->getNoOfCarePacksOutPut($date);

        return $totalCarePacksInWarehouse;
    } //end method getNumberOfCarePacksBeforeAndAt

    public function getNoOfCarePacksInput($date = null)
    {
        $date = $date ?? now();
        $qDate = Carbon::create((string)$date)->endOfDay();
        $noOfReceivedTransfers = $this->packTransferReceived()
            ->where('created_at', '<=', $qDate)
            ->sum('quantity');

        $noOfReceivedPacks = $this->receivedPacks()
            ->where('created_at', '<=', $qDate)
            ->sum('quantity');

        return $noOfReceivedTransfers + $noOfReceivedPacks;
    } //end method getNoOfCarePacksInput

    public function getNoOfCarePacksOutPut($date = null)
    {
        $date = $date ?? now();
        $qDate = Carbon::create((string)$date)->endOfDay();
        $noOfPackRequests = $this->packRequests()
            ->where([
                ['created_at', '<=', $qDate],
                ['status', '<>', PackRequest::STATUS['CANCELED']]
            ])
            ->sum('quantity');

        $noOfSentTansfers = $this->packTransferSent()
            ->where('created_at', '<=', $qDate)
            ->sum('quantity');
        return $noOfPackRequests + $noOfSentTansfers;
    } // end method getNoOfCarePacksOutPut

    public function packRequests()
    {
        return $this->hasMany(PackRequest::class);
    } //end metho carePacks

    public function receivedPacks()
    {
        return $this->hasMany(Pack::class);
    } //end method receivedPacks

    public function packTransferReceived()
    {
        return $this->hasMany(PackTransfer::class, 'warehouse_to');
    } //end method packTransferReceived

    public function packTransferSent()
    {
        return $this->hasMany(PackTransfer::class, 'warehouse_from');
    } //end method packTransferSent
}//end class Warehouse
