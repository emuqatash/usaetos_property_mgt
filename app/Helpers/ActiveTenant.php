<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Builder;

class ActiveTenant
{
    public static function active(Builder $query): Builder {
        return $query->where('active', 1);
    }
}
