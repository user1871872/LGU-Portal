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
        Schema::table('apply_permits', function (Blueprint $table) {
            $table->dropColumn(['line_of_business', 'sanitary_permit', 'barangay_permit']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apply_permits', function (Blueprint $table) {
            $table->string('line_of_business')->nullable();
            $table->string('sanitary_permit')->nullable();
            $table->string('barangay_permit')->nullable();
        });
    }
};
