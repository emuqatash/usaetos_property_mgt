<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class TenantContractPaymentDetail extends Model
{
        protected $fillable = [
            'tenant_contract_id',
            'payment_date',
            'payment_amount',
            'company_id',
        ];

    // public $timestamps = false;

    public function tenantContract(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TenantContract::class);
    }

        public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Company::class);
        }

// Delete or keep below as per business requirements
        protected static function booted(): void
        {
            static::addGlobalScope(new CompanyScope());
        }
}
