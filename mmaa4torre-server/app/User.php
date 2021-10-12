<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'Users_available';
    protected $fillable = [
        'username',
        'name'
    ];
}