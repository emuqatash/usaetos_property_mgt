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
            'property_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('IgnoreDuplicates')) {
                        return;
                    }
                    $exists = DB::table('tenant_contracts')
                        ->whereDate('end_date', '>=', now())
                        ->where('active', 1)
                        ->where('id', '!=', $this->input('id'))
                        ->where('property_id', $value) // Add this line
                        ->exists();
                    if ($exists) {
                        $fail('The property is currently under a valid and active contract.');
                    }
                },
            ],
            'description' => 'required',
            'late_fee' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'grace_period' => 'required',

        ];
    }
}
