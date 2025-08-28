<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_schools_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('code')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['tenant_id', 'code'], 'uq_schools_tenant_code');
        });
    }
    public function down(): void {
        Schema::dropIfExists('schools');
    }
};
