<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyRent extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'payment_amount',
        'payment_date',
        'company_id'
    ];

    // public $timestamps = false;

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

//    public function tenantContracts(): HasMany
//    {
//        return $this->hasMany(TenantContract::class,'property_id','property_id');
//    }
}
