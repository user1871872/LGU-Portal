<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTownsTable extends Migration
{
    public function up()
    {
        Schema::create('towns', function (Blueprint $table) {
            $table->id('town_id');
            $table->unsignedBigInteger('province_id'); // Foreign Key
            $table->string('name');
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('province_id')->references('province_id')->on('provinces')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('towns');
    }
}

