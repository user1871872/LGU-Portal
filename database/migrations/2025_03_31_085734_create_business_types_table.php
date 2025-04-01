<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('business_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Business type name (e.g., Retail, Wholesale)
            $table->timestamps();
        });

        // Insert default business types
        DB::table('business_types')->insert([
            ['name' => 'Retail'],
            ['name' => 'Wholesale'],
            ['name' => 'Manufacturing'],
            ['name' => 'Service'],
            ['name' => 'Food & Beverage'],
            ['name' => 'Construction'],
            ['name' => 'Transportation'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('business_types');
    }
};
