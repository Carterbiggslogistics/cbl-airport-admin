<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRequestingToOxygenRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oxygen_requests', function (Blueprint $table) {
            $table->boolean('isRequestingPickup')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oxygen_requests', function (Blueprint $table) {
            $table->dropColumn('isRequestingPickup');
        });
    }
}
