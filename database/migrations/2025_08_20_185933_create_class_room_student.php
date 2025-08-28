<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
     /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('class_room_student', function (Blueprint $table) {
            $table->id();

            $table->uuid('tenant_id')->index();
            $table->foreign('tenant_id', 'fk_cls_std_tenant')
                  ->references('id')->on('tenants')
                  ->cascadeOnDelete();

            $table->foreignId('class_room_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['tenant_id', 'class_room_id', 'student_id'], 'uq_cls_std_tenant_class_student');
        });
    }
    public function down(): void {
        Schema::dropIfExists('class_room_student');
    }
};
