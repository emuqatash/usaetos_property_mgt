<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantContractPaymentDetail extends Model
{
    use HasFactory;

        protected $fillable = [
            'field_name',
            'field_name',
            'field_name',
            'field_name',
            'field_name',
            'field_name',
            'country_id', // Delete or keep below as per business requirements
        ];

    // public $timestamps = false;

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
