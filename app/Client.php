<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
	protected $fillable = ['name', 'slug', 'path_image'];

	public function odts()
	{
		return $this->hasMany('App\ODT');
	}
	public function users()
	{
		return $this->hasMany('App\User');
	}
}
