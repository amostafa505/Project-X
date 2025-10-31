<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctors';

    protected $fillable = [
        'tenant_id', 'branch_id', 'organization_id',
        'first_name', 'last_name', 'email', 'phone',
        'specialty', 'license_no', 'is_active'
    ];
    public $translatable = ['specialty'];


    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}
