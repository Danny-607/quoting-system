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
            $username = $user->name;
            return view('admin.index', compact('username','users', 'roles'));
        } else{
            return redirect()->route('login');
        }
       
        
    }
    
    public function store(Request $request){
        $user = User::findOrFail($request->user_id); // Find the user by ID
        $role = $request->role; // Get the role from the request

        $user->syncRoles($role); // Assign the role to the user

        return back()->with('success', 'Role assigned successfully!');
    }
}
