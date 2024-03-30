<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){

        $user = Auth::user();

        if ($user){
            $username = $user->name;
            return view('admin.index', ['username'=> $username]);
        } else{
            return redirect()->route('login');
        }
       
        
    }
    // edit services
    public function edit(){

    }
}
