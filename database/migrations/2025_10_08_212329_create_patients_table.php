<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            // Multi-tenant scope
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Identity
            $table->string('mrn')->unique(); // Medical Record Number
            $table->string('first_name');
            $table->string('last_name')->nullable();

            // Demographics
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->index();
            $table->date('dob')->nullable()->index();

            // Contacts
            $table->string('phone')->nullable()->index();
            $table->string('email')->nullable()->index();

            // Translatable address (optional, but prepared for i18n)
            $table->json('address')->nullable(); // {"en":"...","ar":"..."}

            // Clinical basics
            $table->string('blood_group')->nullable();
            $table->text('allergies')->nullable();
            $table->text('chronic_conditions')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
