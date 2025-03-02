<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangaysTable extends Migration
{
    public function up()
    {
        Schema::create('barangays', function (Blueprint $table) {
            $table->id('barangay_id'); // Primary Key
            $table->unsignedBigInteger('town_id'); // Foreign Key
            $table->string('name');
            $table->timestamps();

            // Fix Foreign Key Constraint
            $table->foreign('town_id')->references('town_id')->on('towns')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangays');
    }
}
