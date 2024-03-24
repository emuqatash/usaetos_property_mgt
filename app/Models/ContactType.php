<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    protected $fillable = ['name', 'company_id'];
    public $timestamps = false;

//    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
//    {
//        return $this->hasMany(Contact::class);
//    }
}
