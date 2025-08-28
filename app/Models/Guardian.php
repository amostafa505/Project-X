<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Guardian extends Model
{
    use BelongsToTenant , HasFactory;

    protected $fillable = ['tenant_id','name','email','phone','relation','status'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
