<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'payment_date',
        'property_expense_category_id',
        'description',
        'payment_amount',
        'receipt_id',
        'supplier',
        'company_id',
    ];

    // public $timestamps = false;

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function property(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function propertyExpenseAttachmentFiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PropertyExpenseAttachmentFile::class);
    }

    public function propertyExpenseCategory(): BelongsTo
    {
        return $this->belongsTo(PropertyExpenseCategory::class);
    }
}
