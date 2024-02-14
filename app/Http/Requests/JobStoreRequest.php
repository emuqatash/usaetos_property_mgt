<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_id' => 'required',
            'job_number' => 'required',
            'job_location' => 'required',
            'job_type' => 'required',
            'roof_type' => 'required',
            'insurance_agents_id' => 'required',
            'insurance_claim_number' => 'required',
            'permitFiles.*' => 'nullable|mimes:jpeg,jpe,jpg,gif,png,webp|max:10240', // 10 MB
            'attachmentFiles.*' => 'nullable|mimes:jpeg,jpe,jpg,gif,png,webp|max:10240'  // 10 MB
        ];
    }
}
