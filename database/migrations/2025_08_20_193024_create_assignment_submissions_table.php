<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('assignment_submissions', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_asubs_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('assignment_id')->constrained('assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->dateTime('submitted_at')->nullable();
            $table->decimal('score', 6, 2)->nullable();
            $table->string('grade')->nullable();
            $table->string('status')->default('submitted'); // submitted/graded/late
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id','assignment_id','student_id'], 'uq_asubs_tenant_assignment_student');
        });
    }
    public function down(): void {
        Schema::dropIfExists('assignment_submissions');
    }
};
