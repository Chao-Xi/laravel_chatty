<?php

namespace Chatty\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{   
    use Authenticatable;

    protected $table="users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','first_name','last_name','location',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getName()
    {
      if($this->first_name && $this->last_name)
      {
        return "{$this->first_name} {$this->last_name}";
      }
      if($this->first_name)
      {
        return $this->first_name;  
      }
      return null;
    }

    public function getNameorUsername()
    {
        return $this->getName() ?: $this->username;
    }

    public function getFirstNameorUsername()
    {
        return $this->first_name ?: $this->username;
    }

    public function getAvatarUrl()
    {
       return "https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50/{{md5($this->email)}}?d=mm&s=60"; 
    }

}
