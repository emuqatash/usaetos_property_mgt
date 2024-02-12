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
        Schema::table('specifications', function (Blueprint $table) {
            $table->dropColumn([
                'roof',
                'drip_edge',
                'exhaust_cap',
                'pipe_jack',
                'furnace_and_chimney',
                'skylight',
                'attachment_file_name',
                'attachment_file_original_name',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specifications', function (Blueprint $table) {
            $table->json('roof')->nullable();
            $table->json('drip_edge')->nullable();
            $table->json('exhaust_cap')->nullable();
            $table->json('pipe_jack')->nullable();
            $table->json('furnace_and_chimney')->nullable();
            $table->json('skylight')->nullable();
            $table->string('attachment_file_name')->nullable();
            $table->string('attachment_file_original_name')->nullable();
        });
    }
};
