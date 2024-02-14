<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceAgent extends Model
{
        protected $fillable = [
            'agency_name',
            'agent_name',
            'address_line',
            'city',
            'state',
            'zip',
        ];

     public $timestamps = false;

    public function jobs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Job::class);
    }
}
