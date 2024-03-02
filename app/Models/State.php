<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function contracts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function properties(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Property::class);
    }
}
