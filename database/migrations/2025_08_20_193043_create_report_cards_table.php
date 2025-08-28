<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_reportcards_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();

            $table->decimal('gpa', 4, 2)->nullable();
            $table->json('summary')->nullable(); // subject-level breakdown etc.
            $table->string('status')->default('draft'); // draft/published
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->unique(['tenant_id','student_id','term_id'], 'uq_reportcards_tenant_student_term');
        });
    }
    public function down(): void {
        Schema::dropIfExists('report_cards');
    }
};
