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
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->nullable()->constrained()->onDelete('set null');
            $table->json('roof')->nullable();
            $table->json('drip_edge')->nullable();
            $table->json('exhaust_cap')->nullable();
            $table->json('pipe_jack')->nullable();
            $table->json('furnace_and_chimney')->nullable();
            $table->json('skylight')->nullable();
            $table->string('comments')->nullable();
            $table->string('attachment_file_name')->nullable();
            $table->string('attachment_file_original_name')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
