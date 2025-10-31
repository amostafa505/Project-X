<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Patient extends Model
{
    use HasTranslations;
    protected $table = 'patients';


    protected $fillable = [
        'tenant_id', 'branch_id', 'organization_id',
        'mrn', 'first_name', 'last_name', 'gender', 'dob',
        'phone', 'email', 'address', 'blood_group', 'allergies', 'chronic_conditions'
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    public $translatable = ['address'];

    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }
}
