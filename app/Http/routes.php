<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'uses'=>'\Chatty\HTTP\Controllers\HomeController@index',
    'as'=>'home',
]);

// Route::get('/alert',function(){
//       return redirect()->route('home')->with('info','you have signed up!');
//     }
// );

/**
  *Authentication
 */
Route::get('/signup',[
     'uses'=>'\Chatty\Http\Controllers\AuthController@getSignup',
     'as'=>'auth.signup'
	]);

Route::post('/signup',[
     'uses'=>'\Chatty\Http\Controllers\AuthController@postSignup'
	]);

Route::get('/signin',[
     'uses'=>'\Chatty\Http\Controllers\AuthController@getSignin',
     'as'=>'auth.signin'
	]);

Route::post('/signin',[
     'uses'=>'\Chatty\Http\Controllers\AuthController@postSignin'
	]);

Route::get('/signout',[
     'uses'=>'\Chatty\Http\Controllers\AuthController@getSignout',
     'as'=>'auth.signout'
	]);