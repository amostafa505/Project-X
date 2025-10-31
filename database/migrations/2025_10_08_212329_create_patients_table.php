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
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            $table->string('mrn');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('allergies')->nullable();
            $table->text('chronic_conditions')->nullable();

            $table->timestamps();

            // Uniqueness should be per-tenant
            $table->unique(['tenant_id', 'mrn'], 'patients_tenant_mrn_unique');
            $table->unique(['tenant_id', 'phone'], 'patients_tenant_phone_unique');
            $table->unique(['tenant_id', 'email'], 'patients_tenant_email_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
