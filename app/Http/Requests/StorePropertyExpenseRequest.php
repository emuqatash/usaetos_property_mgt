<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_date' => 'required',
            'property_expense_category_id' => 'required',
            'description' => 'required',
            'payment_amount' => 'required',
        ];
    }
}
