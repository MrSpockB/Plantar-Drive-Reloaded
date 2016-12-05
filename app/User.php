<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Cartalyst\Sentinel\Users\EloquentUser as CartalystUser;

class User extends CartalystUser
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'permissions',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = ['full_name'];
    public function odts()
    {
        return $this->belongsToMany('App\ODT', 'odt_user', 'user_id', 'odt_id');
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function getFullNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }
}
