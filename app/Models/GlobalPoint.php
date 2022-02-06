<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalPoint extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'index',
        'subIndex',
        'confirmed',
        'description',
        'checklist',
        'company',
        'point'
    ];

    public function checklist()
    {
        return $this->belongsTo(GlobalChecklist::class, 'checklist');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function master_point()
    {
        return $this->belongsTo(GlobalPoint::class, 'point');
    }

    public function point_point()
    {
        return $this->hasMany(GlobalPoint::class);
    }
}
