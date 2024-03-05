<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignId('contact_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('phone_number_1', 32);
            $table->string('phone_number_2', 32)->nullable();
            $table->string('email')->unique();
            $table->string('address', 128)->nullable();
            $table->string('city', 64)->nullable();
            $table->foreignId('state_id')->nullable()->constrained()->onDelete('set null');
            $table->string('zip', 16)->nullable();
            $table->string('document_id')->nullable();
            $table->string('document2_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
