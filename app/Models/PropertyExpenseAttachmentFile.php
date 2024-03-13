<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;

class PropertyExpenseAttachmentFile extends Model
{
    protected $fillable = [
        'property_expense_id',
        'attachment_file_name',
        'attachment_file',
        'company_id',
    ];

    protected $casts = [
        'attachment_file_name' => 'array',
        'attachment_file' => 'array',
    ];

    public function propertyExpense(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PropertyExpense::class);
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
