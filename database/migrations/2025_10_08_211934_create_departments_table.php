<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            // Multi-tenant scope
            $table->uuid('tenant_id')->index();
            $table->uuid('branch_id')->nullable()->index();
            $table->unsignedBigInteger('organization_id')->nullable()->index();

            // Translatable fields
            $table->json('name');                // {"en": "...", "ar": "..."}
            $table->json('description')->nullable();

            // Meta
            $table->string('code')->nullable()->index();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // (Optional) you can add foreign keys for org/branch if you have those tables centrally
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
