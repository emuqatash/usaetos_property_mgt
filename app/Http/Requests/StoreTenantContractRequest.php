<?php

namespace App\Http\Requests;

use DB;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenantContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contract_no' => 'required',
            'residential_tenancy_agreement' => 'required',
            'property_id' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }
}
