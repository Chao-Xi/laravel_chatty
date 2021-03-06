<?php

namespace Chatty\Models;

use Chatty\Models\Status;
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

    public function statuses()
    {
     return $this->hasMany('Chatty\Models\Status','user_id'); 
    }

     public function likes()
    {
     return $this->hasMany('Chatty\Models\Like','user_id'); 
    }

    public function friendsOfMine()
    {
       return $this->belongsToMany('Chatty\Models\User','friends','user_id','friend_id');  
    }

     public function friendOf()
    {
       return $this->belongsToMany('Chatty\Models\User','friends','friend_id','user_id');  
    }
    
    public function friends()
    {
        return $this->friendsOfMine()->wherePivot('accepted',true)->get()->merge($this->friendOf()->wherePivot('accepted',true)->get());
    }

     public function friendRequests()
    {
        return $this->friendsOfMine()->wherePivot('accepted',false)->get();
    }
     
      public function friendRequestsPending()
    {
        return $this->friendOf()->wherePivot('accepted',false)->get();
    }

      public function hasFriendRequestPending(User $user)
    {
        return (bool) $this->friendRequestsPending()->where('id',$user->id)->count();
    }

        public function hasFriendRequestReceived(User $user)
    {
        return (bool) $this->friendRequests()->where('id',$user->id)->count();
    }

        public function addFriend(User $user)
    {
        $this->friendOf()->attach($user->id);
    }
    
        public function deleteFriend(User $user)
    {
        $this->friendOf()->detach($user->id);
         $this->friendOfMine()->detach($user->id);
    }

       public function acceptFriendRequest(User $user)
    {
        $this->friendRequests()->where('id',$user->id)->first()->pivot->update([
               'accepted'=>true,
            ]);
    }

    public function isFriendsWith(User $user)
    {
        return (bool) $this->friends()->where('id',$user->id)->count();
    }

    //  public  function likes()
    // {
    //     return $this->morphMany('Chatty\Models\Like','likeable');
    // }

     public function hasLikedStatus(Status $status)
     {
       return (bool) $status->likes
                            ->where('user_id',$this->id)
                            ->count(); 
     }

}
