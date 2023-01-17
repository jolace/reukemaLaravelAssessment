<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;

class HomeController extends Controller
{
    //
    public function index()
    {        
        $users = User::role('representative')->get();
        return view('dashboard',compact('users'));
    }
}
