<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'tenant_type_id',
        'phone_number_1',
        'phone_number_2',
        'email',
        'document_id',
        'document2_id',
        'remarks',
        'active',
        'company_id',
    ];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function tenantType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TenantType::class);
    }

//    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(State::class);
//    }

    public function tenantAttachmentFiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TenantAttachmentFile::class);
    }
    public function tenantContracts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TenantContract::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }
}
