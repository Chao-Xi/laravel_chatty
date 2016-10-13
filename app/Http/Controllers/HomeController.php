<?php 
namespace Chatty\HTTP\Controllers;
 
class HomeController extends Controller
{
    public function index()
  {
    return view('home');
  }        
}