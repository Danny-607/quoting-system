<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){

        $user = Auth::user();
        $users = User::all(); 
        $roles = Role::all(); 
        if ($user){
            $name = $user->first_name;
            return view('admin.index', compact('name','users', 'roles'));
        } else{
            return redirect()->route('login');
        }
       
        
    }


    
}
