<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    protected $table = 'Screenshot_users';
    protected $fillable = [
        'username',
        'img',
        'key',
        'tab'
    ];
}