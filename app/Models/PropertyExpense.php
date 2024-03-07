<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyExpense extends Model
{
    use HasFactory;

        protected $fillable = [
            'field_name',
            'field_name',
            'field_name',
            'field_name',
            'field_name',
            'field_name',
            'field_name',
        ];

    // public $timestamps = false;

        public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Company::class);
        }
}
