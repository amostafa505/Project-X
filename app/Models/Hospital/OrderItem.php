<?php

namespace App\Models\Hospital;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class OrderItem extends Model
{
    use HasFactory, HasTranslations;

    protected $table = 'order_items';

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'organization_id',
        'order_id',
        'type',
        'name',
        'description',
        'code',
        'unit',
        'quantity',
        'price',
        'result',
        'notes',
        'lab_test_id',
    ];

    public $translatable = ['name', 'description', 'result', 'notes'];

    protected $casts = [
        'quantity' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers & Accessors
    |--------------------------------------------------------------------------
    */

    public function getTranslatedName(): ?string
    {
        return $this->getTranslation('name', app()->getLocale()) ?? $this->getTranslation('name', 'en');
    }

    public function getTranslatedResult(): ?string
    {
        return $this->getTranslation('result', app()->getLocale()) ?? $this->getTranslation('result', 'en');
    }
    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }
}
