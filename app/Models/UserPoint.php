<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPoint extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'index',
        'subIndex',
        'confirmed',
        'active',
        'skiped',
        'description',
        'user_checklist',
        'company',
        'user_point'
    ];

    public function user_checklist_relation()
    {
        return $this->belongsTo(UserChecklist::class, 'user_checklist');
    }

    public function company_relation()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function user_point_relation()
    {
        return $this->belongsTo(UserPoint::class, 'user_point');
    }

    public function point_point()
    {
        return $this->hasMany(UserPoint::class);
    }
}
