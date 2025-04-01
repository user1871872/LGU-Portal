<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('apply_permits', function (Blueprint $table) {
            $table->dropColumn('business_type'); // Remove old string column
            $table->unsignedBigInteger('business_type_id')->nullable()->after('business_name');

            // Foreign key constraint
            $table->foreign('business_type_id')->references('id')->on('business_types')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('apply_permits', function (Blueprint $table) {
            $table->dropForeign(['business_type_id']);
            $table->dropColumn('business_type_id');
            $table->string('business_type')->nullable(); // Restore original column if rollback
        });
    }
};
