<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (session()->has('company_id')) {
            $builder->where('company_id', session()->get('company_id'));
//            Log::info('CompanyScope applied with company_id: ' . session()->get('company_id'));
        }
    }
}
