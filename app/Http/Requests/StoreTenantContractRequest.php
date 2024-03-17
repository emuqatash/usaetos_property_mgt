<?php

namespace App\Http\Requests;

use App\Rules\ActiveTenant;
use DB;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                Rule::unique('tenant_contracts')->where(function ($query) {
                    return $query->whereDate('end_date', '>=', now())
                        ->where('active', 1);
                }),
            ],
            'description' => 'required',
            'late_fee' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }
}


//'property_id' => [
//    'required',
//    Rule::unique('tenant_contracts')->ignore($this->route('tenant_contracts'))->where(function ($query) {
//        return $query->whereDate('end_date', '>=', now())
//            ->where('active', 1);
//    }),
//],
