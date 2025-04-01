<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Add the apply_permit_id column
            $table->unsignedBigInteger('apply_permit_id')->after('max_file_size');

            // Add the foreign key constraint
            $table->foreign('apply_permit_id')
                  ->references('id')->on('apply_permits')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            // Drop the foreign key first
            $table->dropForeign(['apply_permit_id']);
            // Then drop the column
            $table->dropColumn('apply_permit_id');
        });
    }
};
