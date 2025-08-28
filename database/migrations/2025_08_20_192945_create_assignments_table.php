<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_assignments_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->unsignedInteger('max_score')->default(100);
            $table->timestamps();

            $table->index(['tenant_id','class_room_id','due_at'], 'ix_assignments_tenant_class_due');
        });
    }
    public function down(): void {
        Schema::dropIfExists('assignments');
    }
};
