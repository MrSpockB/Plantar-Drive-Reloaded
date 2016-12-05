<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ODT extends Model
{
    protected $table = 'odts';
    protected $dates = ['created_at', 'updated_at', 'endDate', 'startDate', 'creationDate'];
    protected $appends = ['time_progress'];
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    public function users()
    {
    	return $this->belongsToMany('App\User', 'odt_user', 'odt_id', 'user_id');
    }
    public function files()
    {
    	return $this->hasMany('App\File', 'odt_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment', 'odt_id');
    }
    public function getTimeProgressAttribute()
    {
        $totalDays = $this->endDate->diffInDays($this->startDate);
        $currentDay = Carbon::now()->diffInDays($this->startDate);
        $currentPercentage = ($currentDay/$totalDays)*100;
        return min($currentPercentage, 100);
    }
}
