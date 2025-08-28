<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = ['name','email','password'];
    protected $hidden   = ['password','remember_token'];

    // Memberships for tenants
    public function memberships()
    {
        return $this->hasMany(TenantUser::class);
    }

    // helper: membership in current tenant
    public function currentMembership(): ?TenantUser
    {
        return tenant() ? $this->memberships()->where('tenant_id', tenant()->id)->first() : null;
    }
}
