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
            $table->foreign('address_id')
                  ->references('address_id')
                  ->on('addresses')
                  ->onDelete('cascade');
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
            $table->dropForeign(['address_id']);
        });
    }
};
