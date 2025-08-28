<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_docs_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->morphs('documentable'); // documentable_type, _id
            $table->string('title')->nullable();
            $table->string('disk')->default('public');
            $table->string('path');  // storage path
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->timestamps();

            $table->index(['tenant_id', 'documentable_type', 'documentable_id'], 'ix_docs_tenant_morph');
        });
    }
    public function down(): void {
        Schema::dropIfExists('documents');
    }};
