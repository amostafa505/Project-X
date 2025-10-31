<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Department extends Model
{
    use HasTranslations;

    protected $table = 'departments';

    protected $fillable = [
        'tenant_id', 'branch_id', 'organization_id',
        'name', 'description', 'code', 'is_active'
    ];

    public $translatable = ['name', 'description'];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
