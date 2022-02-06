<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChecklist extends Model
{
    use HasFactory;
    public $timestamps = true;

    protected $fillable = [
        'user',
        'name',
        'description',
        'checklist_category',
        'allocated_by',
        'global_checklist',
        'company',
        'file',
        'user_comment',
        'status',
        'realization',
        'term',
        'daysToRealization',
        'allowAfterTerm',
        'dateOfRealization'
    ];

    public function allocated_by_relation()
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }

    public function checklist_category_relation()
    {
        return $this->belongsTo(Category::class, 'checklist_category');
    }

    public function file_relation()
    {
        return $this->belongsTo(File::class, 'file');
    }

    public function company_relation()
    {
        return $this->belongsTo(Company::class, 'company');
    }

    public function user_relation()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function global_checklist_relation()
    {
        return $this->belongsTo(GlobalChecklist::class, 'global_checklist');
    }

    public function user_point()
    {
        return $this->hasMany(UserPoint::class);
    }
}
