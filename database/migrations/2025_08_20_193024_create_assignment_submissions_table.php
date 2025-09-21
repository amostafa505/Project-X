<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('assignment_submissions');

        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_asubs_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->foreignId('assignment_id')->nullable()->index();
            // لو عندك assignments: ->constrained('assignments')->nullOnDelete();

            $table->string('status')->default('submitted'); // submitted|graded|late|missing
            $table->decimal('score', 8, 2)->nullable();
            $table->decimal('out_of', 8, 2)->nullable();

            $table->string('file_path')->nullable(); // storage path if file uploaded
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();

            $table->timestamps();

            $table->unique(
                ['tenant_id', 'branch_id', 'term_id', 'student_id', 'assignment_id'],
                'uq_asubs_tenant_branch_term_student_assignment'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignment_submissions');
    }
};
