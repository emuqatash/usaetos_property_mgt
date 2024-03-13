<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class JobAttachmentFile extends Model
{
    protected $fillable = [
        'job_id',
        'attachment_file_name',
        'attachment_file',
        'company_id',
    ];

    protected $casts = [
        'attachment_file_name' => 'array',
        'attachment_file' => 'array',
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
