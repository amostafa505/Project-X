<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('report_cards');

        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_report_cards_tenant')
                ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->nullable()->index()
                ->constrained('branches')->nullOnDelete();

            $table->foreignId('school_year_id')->nullable()->constrained('school_years')->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->decimal('total_score', 10, 2)->nullable();
            $table->decimal('total_out_of', 10, 2)->nullable();
            $table->string('overall_grade')->nullable(); // e.g. A, B+, etc.
            $table->text('remarks')->nullable();

            $table->json('details')->nullable(); // per-subject breakdown

            $table->timestamps();

            $table->unique(
                ['tenant_id', 'branch_id', 'school_year_id', 'term_id', 'student_id'],
                'uq_report_cards_tenant_branch_year_term_student'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_cards');
    }
};
