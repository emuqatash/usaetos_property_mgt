<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'zip',
        'date_of_purchase',
        'area_size',
        'number_of_bedrooms',
        'cost',
        'payments_left',
        'handover_date',
        'property_status',
        'company_id',
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

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

}
