<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'tax_number',
        'city',
        'postcode',
        'sub_exp_date',
        'email',
        'phone'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function point()
    {
        return $this->hasMany(GlobalPoint::class);
    }

    public function userChecklist()
    {
        return $this->hasMany(UserChecklist::class);
    }

    public function user_point()
    {
        return $this->hasMany(UserPoint::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
