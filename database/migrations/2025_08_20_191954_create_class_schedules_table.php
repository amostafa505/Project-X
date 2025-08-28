<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_clsched_tenant')
                  ->references('id')->on('tenants')->cascadeOnDelete();

            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('term_id')->nullable()->constrained('terms')->nullOnDelete();

            $table->unsignedTinyInteger('day_of_week'); // 0=Sun .. 6=Sat (اضبطه حسب احتياجك)
            $table->time('starts_at');
            $table->time('ends_at');
            $table->string('room')->nullable(); // غرفة/معمل
            $table->timestamps();

            $table->unique(
                ['tenant_id','class_room_id','day_of_week','starts_at','ends_at'],
                'uq_clsched_tenant_class_day_time'
            );
        });
    }
    public function down(): void {
        Schema::dropIfExists('class_schedules');
    }
};
