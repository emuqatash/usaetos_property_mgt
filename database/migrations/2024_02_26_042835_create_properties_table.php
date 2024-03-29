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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_no');
            $table->string('name');
            $table->string('address', 128)->nullable();
            $table->string('city', 64)->nullable();
            $table->foreignId('state_id')->nullable()->constrained()->onDelete('set null');
            $table->string('zip', 16)->nullable();
//            $table->string('landlord')->nullable();
//            $table->string('lessor')->nullable();
            $table->string('owner')->nullable();
            $table->string('ownership_rate')->nullable();
            $table->date('date_of_purchase')->nullable();
            $table->string('area_size')->nullable();
            $table->integer('number_of_bedrooms')->nullable();
            $table->decimal('cost', 20, 2)->nullable();
            $table->integer('payments_left')->nullable();
            $table->date('handover_date')->nullable();
            $table->string('property_status', 20)->default('Vacant')->nullable();
            $table->string('property_type', 20)->nullable();
            $table->boolean('active')->default(true);
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
