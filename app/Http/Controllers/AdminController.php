<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Define the index method which handles the main action for this controller.
    public function index(){
        // Retrieve the currently authenticated user.
        $user = Auth::user();
        // Fetch all users from the database.
        $users = User::all();
        // Fetch all roles from the database.
        $roles = Role::all();
        
        // Check if there is an authenticated user.
        if ($user){
            // Get the first name of the user.
            $name = $user->first_name;
            // Return the 'admin.index' view, passing the first name, all users, and all roles data to the view.
            return view('admin.index', compact('name', 'users', 'roles'));
        } else{
            // If no user is authenticated, redirect to the login route.
            return redirect()->route('login');
        }
    }
}
