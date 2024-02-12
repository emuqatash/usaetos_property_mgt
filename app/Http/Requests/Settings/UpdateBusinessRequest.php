<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'company_id' => ['required', 'exists:companies,id'],
            'field' => ['required', 'in:name,address,contract_details'],
            'value' => $this->setValidation(),
        ];
    }

    protected function setValidation(): array
    {
        if ($this->input('field') === 'email') {
            return ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'];
        }

        if ($this->input('field') === 'role_id') {
            return ['required', 'exists:roles,id'];
        }

        if ($this->input('field') === 'password') {
            return ['required', 'min:8'];
        }

        return ['required'];
    }

    public function authorize(): bool
    {
        return true;
    }
}
