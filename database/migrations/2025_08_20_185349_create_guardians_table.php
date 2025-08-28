<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_guardians_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('relation')->nullable(); // father/mother/other
            $table->timestamps();

            $table->unique(['tenant_id', 'email'], 'uq_guardians_tenant_email');
        });
    }
    public function down(): void {
        Schema::dropIfExists('guardians');
    }
};
