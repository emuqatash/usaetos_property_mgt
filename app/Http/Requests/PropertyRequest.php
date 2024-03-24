<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'property_no' => 'required',
            'name' => 'required',
            'owner' => 'required',
            'city' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'property_type' => 'required',
        ];
    }
}
