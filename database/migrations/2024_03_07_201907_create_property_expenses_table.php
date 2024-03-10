<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('property_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('description');
            $table->foreignId('property_expense_category_id')->nullable()->constrained()->onDelete('set null');
            $table->date('payment_date');
            $table->decimal('payment_amount', 20, 2);
            $table->string('receipt_id')->nullable();
            $table->string('supplier')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('property_expenses');
    }
};
