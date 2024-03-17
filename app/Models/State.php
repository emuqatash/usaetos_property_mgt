<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'company_id'];
    public $timestamps = false;

    public function contracts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function properties(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new StateScope());
    }
}
