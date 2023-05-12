<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $hidden = ["status_image_path"];

    const STATUS = [
        'IN-TRANSIT' => 'IN-TRANSIT',
        'PICKED-UP' => 'PICKED-UP',
        'PENDING' => 'PENDING',
        'CANCELED' => 'CANCELED',
        'RETURNED-ORDER' => 'RETURNED-ORDER',
    ];

    const STATUS_IMAGE_FOLDER_PATH = "orders/statuses";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reason()
    {
        return $this->hasOne(Reason::class);
    }

    public function lab()
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    public function rider()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
}
