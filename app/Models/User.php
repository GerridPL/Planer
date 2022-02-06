<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checklist()
    {
        return $this->hasMany(Checklist::class);
    }

    public function userChecklist()
    {
        return $this->hasMany(UserChecklist::class);
    }

    public function user_company_relation()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function user_modelhasrole_relation()
    {
        return $this->morphToMany(ModelHasRole::class, 'id');
    }
}
