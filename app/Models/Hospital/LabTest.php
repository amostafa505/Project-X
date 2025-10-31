<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class LabTest extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'lab_tests';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'organization_id',
        'name',
        'description',
        'category',
        'code',
        'reference_range',
        'unit',
        'price',
        'is_active',
    ];

    public $translatable = ['name', 'description', 'category', 'reference_range'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
