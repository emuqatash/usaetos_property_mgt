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
        Schema::create('property_expense_attachment_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_expense_id')->constrained()->onDelete('cascade');
            $table->string('attachment_file_name');
            $table->string('attachment_file');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_expense_attachment_files');
    }
};
