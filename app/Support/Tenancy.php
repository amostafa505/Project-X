<?php
namespace App\Support;
use Stancl\Tenancy\Database\Models\Domain;

class Tenancy {
    public static function id(): ?string
    {
        return tenant()?->getKey()
            ?? Domain::query()->where('domain', request()->getHost())->value('tenant_id');
    }
}
