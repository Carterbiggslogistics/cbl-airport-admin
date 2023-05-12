<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOxygenAddRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oxygen_add_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oxygen_plant_id');
            $table->unsignedBigInteger('oxygen_size_id');
            $table->unsignedBigInteger('count');
            $table->string('collectedBy')->nullable();
            $table->string('receivedFrom')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //keys
            $table->foreign('oxygen_size_id')
                ->references('id')->on('oxygen_sizes')
                ->onDelete('cascade');

            $table->foreign('oxygen_plant_id')
                ->references('id')->on('oxygen_plants')
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
        Schema::dropIfExists('oxygen_add_requests');
    }
}
