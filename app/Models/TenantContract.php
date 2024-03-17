<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'contract_no',
        'property_id',
        'residential_tenancy_agreement',
        'description',
        'late_fee',
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
        'active',
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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function tenantContractAttachmentFiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TenantContractAttachmentFile::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

}
