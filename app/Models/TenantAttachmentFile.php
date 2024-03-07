<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantAttachmentFile extends Model
{
    protected $fillable = [
        'tenant_id',
        'attachment_file_name',
        'attachment_file',
        'company_id',
    ];

    protected $casts = [
        'attachment_file_name' => 'array',
        'attachment_file' => 'array',
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
