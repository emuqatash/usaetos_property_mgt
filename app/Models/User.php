<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Scopes\CompanyScope;
use App\Models\Scopes\StateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Models\Role;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'company_id',
        'country_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = [
        'role',
    ];

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function company(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function jobs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(JobWork::class, 'job_user', 'user_id', 'job_id');
    }

    public function isAdmin(): bool
    {
        return $this->role->id === 1;
    }

//    Below to functions (getJWTIdentifier, getJWTCustomClaims) related to API - JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new CompanyScope());
        static::addGlobalScope(new StateScope());

        static::creating(function ($model) {
            if (session('company_id')) {
                $model->company_id = session()->get('company_id');
                $model->country_id = session()->get('country_id');
                $model->role_id = 3;
            }
        });

        static::created(function ($model) {
            if (!session('company_id')) {
                $model->company_id = $model->id;
            }
            $model->assignRole('user');
            $model->save();
        });
    }

}
