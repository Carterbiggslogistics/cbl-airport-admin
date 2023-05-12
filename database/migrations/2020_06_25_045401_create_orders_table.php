<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('lab_id');
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->string('quantity');
            $table->string('pickupRegion');
            $table->string('pickupAddress');
            $table->string('deliveryRegion');
            $table->string('deliveryAddress');
            $table->string('deliveryContactName');
            $table->string('deliveryContactPhone');
            $table->string('status')->default('NOT ASSIGNED');
            $table->tinyInteger('is_assigned')->default(0);
            $table->tinyInteger('is_complete')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}