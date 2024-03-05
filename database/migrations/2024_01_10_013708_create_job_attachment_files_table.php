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
        Schema::create('job_attachment_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_work_id');
            $table->foreign('job_work_id')->references('id')->on
                ('job_works')->onDelete('cascade');
            $table->string('attachment_file_name')->nullable();
            $table->string('attachment_file')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_attachment_files');
    }
};
