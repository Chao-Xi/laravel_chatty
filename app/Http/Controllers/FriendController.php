<?php 
 
 namespace Chatty\Http\Controllers;

 use Auth;
 use Illuminate\Http\Request;
 use Chatty\Models\User;



 class FriendController extends Controller
 {
     public function getIndex()
     {
     	$friends=Auth::user()->friends();
     	$requests=Auth::user()->friendRequests();
        return view('friends.index')->with('friends',$friends)
                                    ->with('requests',$requests);
     }

     public function getAdd($username)
     {
        $user=User::where('username',$username)->first();
        if(!$user)
        {
        	return redirect()->route('home')->with('info','That user could not be found');
        }
         if(Auth::user()->id ===$user->id)
         {
         	return redirect()->route('home');
         }
        if(Auth::user()->hasFriendRequestPending($user) || $user->hasFriendRequestPending(Auth::user()))
         {
         	return redirect()->route('profile.index',['username'=>$user->username])->with('info','Friend Request already pending');
         }

         if(Auth::user()->isFriendsWith($user))
         {
         	return redirect()->route('profile.index',['username'=>$user->username])->with('info','you are already friends');
         }
         Auth::user()->addFriend($user);

         return redirect()->route('profile.index',['username'=>$user->username])->with('info','Friend request sent');
     }

     public  function getAccept($username)
     {
        $user=User::where('username',$username)->first();
        if(!$user)
        {
        	return redirect()->route('home')->with('info','That user could not be found');
        }

         if(!Auth::user()->hasFriendRequestReceived($user))
         {
             return redirect()->route('home');
         }
         
         Auth::user()->acceptFriendRequest($user);

         return redirect()->route('profile.index',['username'=>$user->username])->with('info','Friend request accept');
     }
     
     public function postDelete($username)
     {
        $user=User::where('username',$username)->first();
         if(Auth::user()->isFriendsWith($user))
         {
            return redirect()->back();
         }
          Auth::user()->deleteFriend($user);
          return redirect()->back()->with('info','Friend deleted');

     }
 }