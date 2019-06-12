<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;


class UserController extends Controller
{
	
    public function index($sortby = ' '){
    	
    	$users=User::all();  

    	if($sortby != ' '){
    		$users = User::orderby($sortby)->get();
    	}
    	  	

		return view('welcome',compact('users'));
    	
    }

    public function getPost($id){

    	$post = Post::where('userId',$id)->get();
    	$user = User::where('id',$id)->get();
    	$userName = $user[0]->name;    	

    	return view('post',compact('post','userName'));
    }

   
 }
