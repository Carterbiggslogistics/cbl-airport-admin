<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOxygenRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oxygen_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('oxygen_client_id');
            $table->unsignedBigInteger('oxygen_plant_id');
            $table->double('price', 12, 2);
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();

            //Keys
            $table->foreign('oxygen_client_id')
                ->references('id')->on('oxygen_clients')
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
        Schema::dropIfExists('oxygen_requests');
    }
}
