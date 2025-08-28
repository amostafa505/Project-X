<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_examresults_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->decimal('score', 6, 2)->nullable();
            $table->string('grade')->nullable(); // optional denormalized letter
            $table->string('note')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id', 'exam_id', 'student_id'], 'uq_examresults_tenant_exam_student');
        });
    }
    public function down(): void {
        Schema::dropIfExists('exam_results');
    }
};
