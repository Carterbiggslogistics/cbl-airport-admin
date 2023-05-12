<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_requests', function (Blueprint $table) {
            $table->id();
            $table->text("description")->nullable();
            $table->integer("quantity");
            $table->string("pickupRegion");
            $table->string("pickupAddress");
            $table->string("deliveryRegion");
            $table->string("deliveryAddress");
            $table->string("deliveryContactName");
            $table->string("deliveryContactPhone");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("rider_id");
            $table->string("fallbackRiderName")->nullable();
            $table->string("status");
            $table->unsignedBigInteger("warehouse_id");
            $table->string("fallbackWarehouseLocation")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }//end method up

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pack_requests');
    }//end method down
}//end class CreatePaceRequestsTable
