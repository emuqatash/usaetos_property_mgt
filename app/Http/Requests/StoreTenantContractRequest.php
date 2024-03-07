<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('IgnoreDuplicates')) {
                        return;
                    }
                    $exists = DB::table('tenants')
                        ->where('first_name', $this->input('first_name'))
                        ->where('last_name', $this->input('last_name'))
                        ->where('phone_number_1', $this->input('phone_number_1'))
                        ->where('id', '!=', $this->input('id'))
                        ->exists();
                    if ($exists) {
                        $fail('Duplicate first, last name and phone number');
                    }
                },
            ],
            'last_name' => 'required',
            'phone_number_1' => 'required',
            'email' => ['required', 'email'],
            'address' => 'required',
            'city' => 'required',
            'state_id' => 'required',
            'zip' => 'required',
            'tenant_type_id' => 'required',
        ];
    }
}
