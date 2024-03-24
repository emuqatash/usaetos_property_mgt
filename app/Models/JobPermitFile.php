<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class JobPermitFile extends Model
{

    protected $fillable = [
        'job_id',
        'permit_file_name',
        'permit_file',
        'company_id',
    ];

    protected $casts = [
        'permit_file_name' => 'array',
        'permit_file' => 'array',
    ];

    public function jobWork(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(JobWork::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }
}
