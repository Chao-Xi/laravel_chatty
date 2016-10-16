<?php 
namespace Chatty\HTTP\Controllers;
use Chatty\Models\User;
use Illuminate\Http\Request;
use Auth;
 
class AuthController extends Controller
{
     public function getSignup()
     {
     	return view('auth.signup');
     }
     
     public function postSignUp(Request $request)
     {
        $this->validate($request,
          ['email'=>'required|unique:users|email|max:255',
           'username'=>'required|unique:users|max:20',
           'password'=>'required|min:6',
           ]);
         
         User::create(
         	[
              'email'=>$request->input('email'),              
              'username'=>$request->input('username'), 
              'password'=>bcrypt($request->input('password')), 
         	]);

         return redirect()->route('home')->with('info','your account has been created and you can sign in now');
     }

     public function getSignin()
     {
     	return view('auth.signin');
     }
     

     public function postSignin(Request $request)
     {
     	//dd('sign in'); //kill the process dd()

     	 $this->validate($request,
          ['email'=>'required',
           'password'=>'required',
           ]);
     	 
     	 if(!Auth::attempt($request->only(['email','password']),$request->has('remember')))
     	 {
     	 	return redirect()->back()->with('info','could not sign you in with those details');
     	 }
     	 return redirect()->route('home')->with('info','you are now signed in');
     }
     

       public function getSignout()
     {  
     	Auth::logout();
     	return redirect()->route('home');
     }
      
}