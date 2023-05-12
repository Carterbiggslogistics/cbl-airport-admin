<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyTheWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->boolean('canceled')->default(false);
            $table->unsignedBigInteger('user_that_cancel_id')->nullable();
            $table->date('dateCanceled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropColumn('canceled');
            $table->dropColumn('user_that_cancel_id');
            $table->dropColumn('dateCanceled');
        });
    }

}
