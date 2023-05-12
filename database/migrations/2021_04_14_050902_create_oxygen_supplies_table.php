<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOxygenSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oxygen_supplies', function (Blueprint $table) {
            $table->id();
            $table->integer('noOfCylinders');
            $table->unsignedBigInteger('oxygen_size_id');
            $table->unsignedBigInteger('oxygen_request_id');
            $table->timestamps();
            $table->softDeletes();

            //keys
            $table->foreign('oxygen_size_id')
                ->references('id')->on('oxygen_sizes')
                ->onDelete('cascade');

            $table->foreign('oxygen_request_id')
                ->references('id')->on('oxygen_requests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oxygen_supplies');
    }
}
