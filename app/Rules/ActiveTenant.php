<?php

namespace App\Rules;

use App\Models\Tenant;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ActiveTenant implements ValidationRule
{
//    public function validate(string $attribute, mixed $value, Closure $fail): void
//    {
//        //
//    }

    public function passes($attribute, $value): bool
    {
        $tenant = Tenant::where('property_id', $value)
            ->where('active', 1)
            ->first();

        if ($tenant) {
            $activeContract = $tenant->tenantContracts()
                ->whereDate('end_date', '>=', now())
                ->count();

            return $activeContract == 0;
        }

        return true;
    }

    public function message(): string
    {
        return 'The given property_id has an active contract.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // TODO: Implement validate() method.
    }
}
