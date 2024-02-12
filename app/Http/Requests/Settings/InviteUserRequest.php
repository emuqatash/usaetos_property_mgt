<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class InviteUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'role' => ['required', 'exists:roles,id'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }
}
