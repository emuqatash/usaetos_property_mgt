<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_permit_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_work_id');
            $table->foreign('job_work_id')->references('id')->on
                ('job_works')->onDelete('cascade');
            $table->string('permit_file_name');
            $table->string('permit_file');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_permit_files');
    }
};
