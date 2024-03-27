<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_no',
        'name',
        'owner',
        'ownership_rate',
        'address',
        'city',
        'state_id',
        'property_type',
        'zip',
        'date_of_purchase',
        'area_size',
        'number_of_bedrooms',
        'cost',
        'payments_left',
        'handover_date',
        'property_status',
        'active',
        'company_id',
        'country_id',
    ];

    // public $timestamps = false;

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function tenantContracts(): HasMany
    {
        return $this->hasMany(TenantContract::class);
    }

    public function propertyExpenses(): HasMany
    {
        return $this->hasMany(PropertyExpense::class);
    }
    public function propertyRents(): HasMany
    {
        return $this->hasMany(PropertyRent::class);
    }
    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new StateScope());
//        Log::info('Global scope CompanyScope added to Property model');
    }

}
