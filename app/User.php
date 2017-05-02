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
      'admin', 'name', 'username', 'contact_number',  'birthday', 'email', 'password',
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
    		'birthday', 'created_at',
    ];

    public function isAdmin()
    {
      return $this->admin;
    }

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
      return ucwords($value);
    }
}
