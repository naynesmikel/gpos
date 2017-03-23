<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'contact_number',  'birthday', 'email', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $dates = [
		'birthday',
		'created_at',
    ];
    
    public function setNameAttribute($value)
    {
		$this->attributes['name'] = ucwords($value);
    }
    
    public function setPasswordAttribute($value)
    {
		$this->attributes['password'] = bcrypt($value);
    }
    
    public function getNameAttribute($value)
    {
		//return "User: " . $value;
		return ucwords($value);
    }
    
    public function getBirthdayAttribute($value)
    {
		$date = Carbon::parse($value);
		return "$date->month-$date->day-$date->year";
    }
    
    public function getCreatedAtAttribute($value)
    {
		$date = Carbon::parse($value);
		return "$date->month-$date->day-$date->year";
    }
    
//     public function getEmailAttribute($value)
//     {
// 		return strtok($value, '@');
// 	}
}
