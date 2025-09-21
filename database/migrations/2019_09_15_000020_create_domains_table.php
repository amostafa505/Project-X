<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            // نخلي tenant_id UUID متوافق مع tenants.id (uuid)
            $table->uuid('tenant_id')->index();
            $table->string('domain', 255)->unique();
            $table->boolean('is_primary')->default(false)->index();
            $table->timestamps();

            $table->foreign('tenant_id', 'fk_domains_tenant')
                ->references('id')->on('tenants')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
}
