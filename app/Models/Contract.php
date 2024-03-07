<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'property_id',
        'contract_no',
        'residential_tenancy_agreement',
        'description',
        'contact_id',
        'document_id',
        'start_date',
        'end_date',
        'total_period',
        'annual_rent',
        'monthly_rent',
        'term_of_payment',
        'security_deposit',
        'bills_paid_by',
        'note',
        'company_id',
    ];

    // public $timestamps = false;

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}
