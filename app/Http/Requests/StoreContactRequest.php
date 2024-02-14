<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
                    $exists = DB::table('contacts')
                        ->where('first_name', $this->input('first_name'))
                        ->where('last_name', $this->input('last_name'))
                        ->where('phone_number', $this->input('phone_number'))
                        ->where('id', '!=', $this->input('id'))
                        ->exists();
                    if ($exists) {
                        $fail('Duplicate first, last name and phone number');
                    }
                },
            ],
            'last_name' => 'required',
            'phone_number' => 'required',
            'email' => ['required', 'email'],
            'address' => 'required',
            'city' => 'required',
            'state_id' => 'required',
            'zip' => 'required',
            'contact_type_id' => 'required',
        ];
    }
}
