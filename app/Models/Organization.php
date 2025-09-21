<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['name', 'owner_user_id', 'settings'];
    protected $casts = ['settings' => 'array'];

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }
}
