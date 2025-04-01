<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('address_id');
            $table->string('street');
            
            // Foreign keys must reference the correct column name
            $table->unsignedBigInteger('barangay_id');
            $table->unsignedBigInteger('town_id');
            $table->unsignedBigInteger('province_id');

            // Define foreign key constraints
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->onDelete('cascade');
            $table->foreign('town_id')->references('town_id')->on('towns')->onDelete('cascade');
            $table->foreign('province_id')->references('province_id')->on('provinces')->onDelete('cascade');

            $table->string('country');
            $table->string('postal_code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
