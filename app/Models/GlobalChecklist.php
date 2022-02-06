<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GlobalChecklist extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'author',
        'company',
        'checklist_category'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'checklist_category');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function point()
    {
        return $this->hasMany(GlobalPoint::class);
    }

    public function userChecklist()
    {
        return $this->hasMany(userChecklist::class);
    }
}
