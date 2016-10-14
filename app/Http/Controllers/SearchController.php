<?php 
 
 namespace Chatty\Http\Controllers;
 use Illuminate\Http\Request;
 use Chatty\Models\User;
 use DB;

 class SearchController extends Controller
 {
     public function getResults(Request $request)
     {
     	//return view('search.results');
     	$query=$request->input('query');
     	//dd($query);
     	if(!$query)
     	{
     	 return redirect()->route('home');
     	}

     	$users=User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', '%{$query}%')
     	       ->orWhere('username', 'LIKE', "%{$query}%")
     	       ->get();
         
        // dd($users);
     
     return view('search.results')->with('users',$users);
     }
 }