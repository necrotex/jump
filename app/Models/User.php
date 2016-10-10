<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = ['character_id', 'name', 'owner_hash', 'refresh_token', 'corporation_id'];
    protected $hidden = ['refresh_token', 'remember_token'];
}
