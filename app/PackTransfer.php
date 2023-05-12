<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PackTransfer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    const STATUS = [
      'PENDING' => 'PENDING',
      'ON-ROUTE' => 'ON-ROUTE',
      'DELIVERED' => 'DELIVERED'  
    ];

    public function warehouseFrom() {
        return $this->belongsTo(Warehouse::class, 'warehouse_from');
    }//end method warehouseFrom

    public function warehouseTo(){
        return $this->belongsTo(Warehouse::class, 'warehouse_to');
    }//end nethod warehouseTo

    public function rider () {
        return $this->belongsTo(Rider::class);
    }//end method rider
}//end class PackTransfer
