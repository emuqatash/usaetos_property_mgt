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
        Schema::create('tenant_contract_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_contract_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('payment_date');
            $table->decimal('payment_amount', 20, 2);
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_contract_payment_details');
    }
};
