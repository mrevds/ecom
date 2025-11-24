<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    //
    use HasApiTokens, Notifiable;
    protected $fillable = ['username', 'password', 'role_id'];

    public function products()
    {
        return $this->hasMany(Products::class, 'seller_id');
    }

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

}
