<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantType extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public  function tenants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tenant::class);
    }
}
