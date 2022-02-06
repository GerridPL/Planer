<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestUser extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'email',
        'key',
        'company'
    ];
}
