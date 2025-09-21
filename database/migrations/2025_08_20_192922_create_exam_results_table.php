<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('exam_results');

        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_exam_results_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->nullOnDelete();

            // optional exam reference if exists
            // $table->foreignId('exam_id')->nullable()->constrained('exams')->nullOnDelete();

            $table->decimal('score', 8, 2)->nullable();
            $table->decimal('out_of', 8, 2)->default(100);
            $table->string('grade')->nullable(); // A+, A, B, ...

            $table->json('meta')->nullable(); // remarks, rubric, etc.
            $table->timestamps();

            $table->unique(
                ['tenant_id', 'branch_id', 'term_id', 'student_id', 'subject_id'],
                'uq_exam_results_tenant_branch_term_student_subject'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
