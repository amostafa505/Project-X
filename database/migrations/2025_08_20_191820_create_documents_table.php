<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('documents');

        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_documents_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            $table->unsignedBigInteger('owner_user_id')->nullable()->index();
            // $table->foreign('owner_user_id')->references('id')->on('users')->nullOnDelete(); // فعّل لو جاهز

            $table->string('title');
            $table->string('file_path');     // storage path
            $table->string('mime_type', 127)->nullable();
            $table->unsignedBigInteger('size')->nullable();

            $table->enum('visibility', ['private', 'branch', 'tenant', 'public'])->default('tenant')->index();

            $table->json('meta')->nullable(); // tags, descriptions, etc.
            $table->timestamps();

            $table->index(['tenant_id', 'branch_id', 'visibility'], 'documents_scope_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
