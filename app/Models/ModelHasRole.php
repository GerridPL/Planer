<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'model_id';

    protected $fillable = [
        'role_id',
        'model_id'
    ];

    public function modelhasrole_user_relation()
    {
        return $this->morphedByMany(User::class, 'model_id');
    }

    public function modelhasrole_role_relation()
    {
        return $this->morphedByMany(Role::class, 'role_id');
    }
}
