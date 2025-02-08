<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apply_permits', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('business_name');
            $table->string('line_of_business');
            $table->string('business_address');
            $table->string('or_number');
            $table->decimal('amount_paid', 10, 2);
            $table->string('contact_number');
            $table->string('sanitary_permit')->nullable();
            $table->string('barangay_permit')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apply_permits');
    }
};
