<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class FeeItem extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id','name','code','amount','currency','is_active'];
}
