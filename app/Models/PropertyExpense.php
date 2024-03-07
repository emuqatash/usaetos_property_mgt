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


//$table->foreignId('property_id')->nullable()->constrained()->onDelete('set null');
//$table->string('description');
//$table->string('category');
//$table->date('payment_date');
//$table->decimal('payment_amount', 20, 2);
//$table->string('receipt_id')->nullable();
//$table->integer('supplier')->nullable();
    // public $timestamps = false;

        public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(Company::class);
        }
}
