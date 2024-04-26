<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    // Method to display the form for creating a new role.
    public function create()
    {
        $permissions = Permission::all(); // Retrieve all permissions from the database.
        $user = Auth::user(); // Get the currently authenticated user.

        if ($user) { // Check if a user is authenticated.
            $name = $user->first_name; // Get the first name of the authenticated user.
            return view('roles.create', compact('name', 'permissions')); // Return the create role view with user name and permissions.
        } else {
            return redirect()->route('login'); // Redirect to login page if no user is authenticated.
        }
    }

    // Method to handle the storage of a newly created role.
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|unique:roles,name', // Ensure the role name is unique in the 'roles' table.
            'permissions' => 'sometimes|array', // Permissions array is optional but must be an array when provided.
            'permissions.*' => 'exists:permissions,id' // Ensure each permission ID exists in the 'permissions' table.
        ]);

        // Create a new role with the validated name.
        $role = Role::create(['name' => $validated['name']]);

        // If permissions were provided, sync them with the role.
        if (!empty($validated['permissions'])) {
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
        }

        // Redirect to the admin index route with a success message.
        return redirect()->route('admin.index')->with('success', 'Role created successfully.');
    }

    // Method to display the form for editing an existing role.
    public function edit(Role $role)
    {
        $user = Auth::user(); // Get the currently authenticated user.
        $permissions = Permission::all(); // Retrieve all permissions.

        if ($user) { // Check if a user is authenticated.
            $name = $user->first_name; // Get the first name of the authenticated user.
            return view('roles.edit', compact('name', 'role', 'permissions')); // Return the edit role view with role data and permissions.
        } else {
            return redirect()->route('login'); // Redirect to login page if no user is authenticated.
        }
    }

    // Method to handle the updating of an existing role.
    public function update(Request $request, Role $role)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id, // Ensure role name is unique, except for the current role being updated.
            'permissions' => 'sometimes|array', // Permissions array is optional but must be an array when provided.
            'permissions.*' => 'exists:permissions,id' // Check each permission ID exists.
        ]);

        // Update the role with the new name.
        $role->update(['name' => $validated['name']]);

        // Retrieve and sync permissions if provided.
        $permissions = isset($validated['permissions']) ? Permission::whereIn('id', $validated['permissions'])->get() : [];
        $role->syncPermissions($permissions);

        // Redirect to the admin index route with a success message.
        return redirect()->route('admin.index')->with('success', 'Role updated successfully.');
    }

    // Method to delete a role.
    public function destroy(Role $role)
    {
        $role->delete(); // Delete the specified role.
        return redirect()->route('admin.index')->with('success', 'Role deleted successfully.'); // Redirect with a success message.
    }
}
