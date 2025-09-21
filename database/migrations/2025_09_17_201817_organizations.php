<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('owner_user_id')->nullable()->index();
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        if (Schema::hasTable('tenants') && Schema::hasColumn('tenants', 'organization_id')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->foreign('organization_id', 'fk_tenants_org')
                    ->references('id')->on('organizations')
                    ->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tenants')) {
            Schema::table('tenants', function (Blueprint $table) {
                $table->dropForeign('fk_tenants_org');
            });
        }
        Schema::dropIfExists('organizations');
    }
};
