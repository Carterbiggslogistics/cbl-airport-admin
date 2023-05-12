<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename');
            $table->string('email')->unique();
            $table->string('staffId');
            $table->string('gender');
            $table->string('phoneNumber');
            $table->text('dob');
            $table->string('designation');
            $table->string('employmentStatus');
            $table->string('location');
            $table->string('employmentDate');
            $table->string('emergencyContactName');
            $table->string('emergencyContactNumber');
            $table->string('emergencyContactNameTwo');
            $table->string('emergencyContactNumberTwo');
            $table->string('NOKName');
            $table->string('NOKAddress');
            $table->string('NOKPhone');
            $table->string('guarantorName');
            $table->string('guarantorAddress');
            $table->string('guarantorPhone');
            $table->string('bankName');
            $table->string('staffSalary');
            $table->string('bankAccNumber');
            $table->string('PFANumber');
            $table->string('RSANumber');
            $table->string('PFACode');
            $table->string('driversLicense');
            $table->string('expiryDate');
            $table->string('insuranceDate');
            $table->string('PTR');
            $table->string('PRD');
            $table->string('DSFPT');
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
        Schema::dropIfExists('riders');
    }
}