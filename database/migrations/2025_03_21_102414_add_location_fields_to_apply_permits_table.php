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
            $table->string('province')->nullable()->after('line_of_business');
            $table->string('town')->nullable()->after('province');
            $table->string('barangay')->nullable()->after('town');
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
            $table->dropColumn(['province', 'town', 'barangay']);
        });
    }
};
