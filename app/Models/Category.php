<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'company'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'id');
    }

    public function checklist()
    {
        return $this->hasMany(Checklist::class);
    }

    public function user_checklist()
    {
        return $this->hasMany(UserChecklist::class);
    }
}
