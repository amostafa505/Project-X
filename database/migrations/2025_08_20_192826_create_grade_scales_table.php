<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('grade_scales', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_gradescales_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()
                  ->constrained('branches')->nullOnDelete();

            $table->string('name');        // e.g. "Default 100-point"
            $table->string('letter');      // A, B+, C...
            $table->decimal('min_score', 5, 2);
            $table->decimal('max_score', 5, 2);
            $table->unsignedTinyInteger('gpa_points')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id','branch_id','name','letter'], 'uq_gradescales_tenant_branch_letter');
        });
    }
    public function down(): void {
        Schema::dropIfExists('grade_scales');
    }
};
