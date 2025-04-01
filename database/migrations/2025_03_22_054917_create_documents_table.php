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
        Schema::create('documents', function (Blueprint $table) {
            $table->id('document_id'); // Primary Key
            $table->unsignedBigInteger('apply_permit_id'); // Foreign Key

            // File Columns
            $table->string('sanitary_permit')->nullable();
            $table->string('barangay_permit')->nullable();
            $table->string('dti_certificate')->nullable();
            $table->string('official_receipt')->nullable();
            $table->string('police_clearance')->nullable();
            $table->string('tourism_compliance_certificate')->nullable();

            // File Metadata
            $table->string('file_format')->nullable();
            $table->integer('max_file_size')->nullable();

            // Timestamps
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('apply_permit_id')->references('id')->on('apply_permits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
