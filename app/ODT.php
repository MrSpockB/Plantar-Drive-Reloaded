<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ODT extends Model
{
    protected $table = 'odts';
    public function users()
    {
    	return $this->belongsToMany('App\User', 'odt_user', 'odt_id', 'user_id');
    }
    public function files()
    {
    	return $this->hasMany('App\File');
    }
}
