<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class School extends Model
{
    use BelongsToTenant ,HasFactory;

    protected $fillable = ['tenant_id','name','code','phone','address','status'];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}
