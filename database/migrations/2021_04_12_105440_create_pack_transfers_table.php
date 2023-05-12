<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pack_transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quantity');
            $table->string('receivedFrom');
            $table->string('collectedBy');
            $table->string('status');
            $table->unsignedBigInteger('warehouse_from');
            $table->unsignedBigInteger('warehouse_to');
            $table->unsignedBigInteger('rider_id');
            $table->text('reason');
            
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
        Schema::dropIfExists('pack_transfers');
    }
}
