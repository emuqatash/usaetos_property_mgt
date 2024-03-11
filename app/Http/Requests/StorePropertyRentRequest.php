<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_id'=> 'required',
            'payment_date' => 'required',
            'payment_amount' => 'required',
        ];
    }
}
