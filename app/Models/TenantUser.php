<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class TenantUser extends Model
{
    // BelongsToTenant هنا optional
    // لو حابب أي استعلام يتفلتر أوتوماتيك بالـ tenant_id الحالي، سيبه
    // لو شايفه Pivot أكتر، ممكن تشيله وتدير tenant_id يدوي

    use BelongsToTenant;

    protected $table = 'tenant_users';
    protected $fillable = ['tenant_id','user_id','branch_id','status','locale','meta'];
    protected $casts   = ['tenant_id' => 'string', 'meta' => 'array'];

    public function tenant()
    {
        return $this->belongsTo(\Stancl\Tenancy\Database\Models\Tenant::class, 'tenant_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
