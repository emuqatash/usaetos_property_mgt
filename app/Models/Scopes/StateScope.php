<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StateScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (session()->has('country_id')) {
            $builder->where('country_id', session()->get('country_id'));
        }
    }
}
