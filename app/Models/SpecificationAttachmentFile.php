<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecificationAttachmentFile extends Model
{
        protected $fillable = [
            'specification_id',
            'attachment_file_name',
            'attachment_file',
            'company_id',
        ];

    protected $casts = [
        'attachment_file_name' => 'array',
        'attachment_file' => 'array',
    ];

    public function specification(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Specification::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
