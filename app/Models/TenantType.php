<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class TenantType extends Model
{
    protected $fillable = ['name', 'company_id'];
    public $timestamps = false;

    public  function tenants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tenant::class);
    }

//    protected static function booted(): void
//    {
//        static::addGlobalScope(new CompanyScope());
//    }

}
