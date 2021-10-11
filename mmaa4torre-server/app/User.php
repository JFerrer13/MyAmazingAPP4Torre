<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'USERS_AVAILABLE';
    protected $fillable = [
        'USERNAME',
        'NAME'
    ];
}