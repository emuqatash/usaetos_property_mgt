<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenant_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
//            $table->foreignId('property_id')->constrained()->onDelete('set null');
            $table->integer('property_id');
            $table->string('contract_no');
            $table->string('residential_tenancy_agreement');
            $table->string('description')->nullable();
            $table->decimal('late_fee')->default(0)->nullable();
            $table->integer('grace_period')->default(0)->nullable();
            $table->string('document_id')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('total_period')->nullable();
            $table->string('payment_frequency')->nullable();
            $table->decimal('rent_amount', 20, 2)->nullable();
            $table->string('term_of_payment')->nullable();
            $table->decimal('security_deposit', 20, 2)->nullable();
            $table->string('bills_paid_by')->nullable();
            $table->text('note')->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_contracts');
    }
};
