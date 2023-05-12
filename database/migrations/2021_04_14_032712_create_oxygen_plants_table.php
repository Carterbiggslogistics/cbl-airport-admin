<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOxygenPlantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oxygen_plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');

            $table->string('email')->unique();
            $table->string('phoneNumber');
            $table->string('state');
            $table->string('country');
            $table->string('region');
            $table->string('city');

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
        Schema::dropIfExists('oxygen_plants');
    }
}
