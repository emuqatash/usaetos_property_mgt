<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'contract_details',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function tenants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tenant::class);
    }

    public function propertys(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function jobWorks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JobWork::class);
    }
}
