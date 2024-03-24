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
        Schema::create('property_rents', function (Blueprint $table) {
            $table->id();
            $table->decimal('payment_amount', 20, 2);
            $table->decimal('late_fee', 20, 2)->default(0);
            $table->date('payment_date');
            $table->foreignId('property_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_rents');
    }
};
