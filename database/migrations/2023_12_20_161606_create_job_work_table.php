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
        Schema::create('job_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->json('salesman_ids')->nullable();
            $table->string('job_number');
            $table->string('job_location');
            $table->string('job_type');
            $table->string('roof_type');
            $table->string('job_status')->nullable();
            $table->foreignId('insurance_agents_id')->nullable()->constrained();
            $table->string('insurance_claim_number')->nullable();
            $table->string('notes')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_works');
    }
};
