<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    public function role_modelhasrole_relation()
    {
        return $this->morphToMany(ModelHasRole::class, 'id');
    }
}
