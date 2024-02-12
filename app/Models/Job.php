<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Job extends Model
{
    protected $fillable = [
        'contact_id',
        'user_id',
        'salesman_ids',
        'job_number',
        'job_location',
        'job_type',
        'roof_type',
        'job_status',
        'insurance_agents_id',
        'insurance_claim_number',
        'notes',
        'company_id',
    ];

    protected $casts = [
        'salesman_ids' => 'array',
    ];

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contact(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function salesmen(): Collection
    {
        $salesmanIds = $this->salesman_ids;
        if (is_null($salesmanIds)) {
            return collect();
        }
        return User::findMany($salesmanIds);
    }

    public function insuranceAgent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(InsuranceAgent::class, 'insurance_agents_id');
    }

    public function jobPermitFiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JobPermitFile::class);
    }

    public function jobAttachmentFiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(JobAttachmentFile::class);
    }

    public function specification(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Specification::class);
    }
}


