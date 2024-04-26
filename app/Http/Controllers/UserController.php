<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display the form for creating a new user.
    public function create()
    {
        $name = Auth::user()->first_name; // Retrieve the first name of the currently authenticated user.
        $roles = Role::all(); // Fetch all roles from the database.
        return view('users.create', compact('name', 'roles')); // Return the create user view with roles and the authenticated user's name.
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data.
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required'
        ]);

        // Create a new user instance and fill it with validated data.
        $user = new User($validatedData);
        $user->password = Hash::make($request->password); // Hash the password before storing it.
        $user->syncRoles($validatedData['role']); // Sync roles for the user.
        $user->save(); // Save the user to the database.

        return redirect()->route('admin.index')->with('success', 'User created successfully.'); // Redirect to the admin index with a success message.
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id); // Retrieve the user by ID or fail.
        $name = Auth::user()->first_name; // Retrieve the first name of the currently authenticated user.
        $roles = Role::all(); // Fetch all roles.
        return view('users.edit', compact('user', 'name', 'roles')); // Return the edit user view with the user, roles, and name.
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Retrieve the user by ID or fail.

        // Validate the incoming data.
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Ensure the email is unique except for the current user.
            'password' => 'required|string|min:8',
        ]);

        // Get the role from the request.
        $role = $request->role;

        // Sync the user's roles.
        $user->syncRoles($role);

        // Update user attributes.
        $user->fill($validatedData);

        // Conditionally hash and update the password if it was provided.
        if ($request->has('password') && !empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Save the user updates.

        return redirect()->route('admin.index')->with('success', 'User updated successfully.'); // Redirect to the admin index with a success message.
    }

    // Delete the specified user from the database.
    public function destroy(User $user)
    {
        $user->delete(); // Delete the user.
        return redirect()->route('admin.index'); // Redirect to the admin index.
    }

}