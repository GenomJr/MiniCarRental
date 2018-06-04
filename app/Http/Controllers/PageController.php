<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){

        return view('welcome');
      }
      public function user(){
      $user = 'test';
        return view('pages.user' , compact('user'));
      }
      public function agent(){
        $isCarRent = true ;
        return view('pages.agent')->with('isCarRent',$isCarRent);
      }
}
