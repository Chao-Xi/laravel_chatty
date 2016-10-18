<?php 
namespace Chatty\HTTP\Controllers;

use Chatty\Models\Status;
use Auth;

class HomeController extends Controller
{  
  
    public function index()
  {
    if(Auth::check())
    {  
    	$statuses=Status::notReply()->where(function($query)
       {
         return $query->where('user_id',Auth::user()->id)->orWhereIn('user_id', Auth::user()->friends()->pluck('id'));
       })->orderBy('created_at','desc')->paginate(3);
    	
    	return view('timeline.index')->with('statuses',$statuses);
    }

    return view('home');
  }        
}