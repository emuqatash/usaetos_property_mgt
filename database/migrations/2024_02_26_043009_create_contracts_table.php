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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('contract_no');
            $table->string('residential_tenancy_agreement');
            $table->string('description')->nullable();
            $table->foreignId('contact_id')->constrained()->onDelete('cascade');
            $table->string('document_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('total_period')->nullable();
            $table->string('annual_rent')->nullable();
            $table->string('term_of_payment')->nullable();
            $table->decimal('security_deposit', 8, 2)->nullable();
            $table->string('addc_bills_paid_by')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
