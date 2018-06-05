<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){

      $title = 'Welcome To Car Rental Service!';
    
      return view('pages.index')->with('title', $title);
      }
    
}
