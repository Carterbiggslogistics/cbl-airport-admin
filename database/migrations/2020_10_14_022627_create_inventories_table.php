<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rider_id')->nullable();
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('pack_id');
            $table->integer('quantity');
            $table->integer('amount')->default(0);
            $table->string('deliveryRegion');
            $table->string('deliveryAddress');
            $table->string('deliveryContactName');
            $table->string('deliveryContactPhone');
            $table->string('status')->default('NOT ASSIGNED');
            $table->tinyInteger('is_assigned')->default(0);
            $table->tinyInteger('is_delivered')->default(0);
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
        Schema::dropIfExists('inventories');
    }
}
