<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_exams_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();

            $table->string('title');        // Midterm, Final, Quiz 1...
            $table->date('exam_date');
            $table->time('starts_at')->nullable();
            $table->time('ends_at')->nullable();
            $table->unsignedInteger('max_score')->default(100);
            $table->string('room')->nullable();
            $table->timestamps();

            $table->index(['tenant_id','class_room_id','exam_date'], 'ix_exams_tenant_class_date');
        });
    }
    public function down(): void {
        Schema::dropIfExists('exams');
    }
};
