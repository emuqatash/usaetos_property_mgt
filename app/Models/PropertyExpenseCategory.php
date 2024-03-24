<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PropertyExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name','company_id'];
    public $timestamps = false;

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function propertyExpenses(): HasMany
    {
        return $this->hasMany(PropertyExpense::class);
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
    }

}
