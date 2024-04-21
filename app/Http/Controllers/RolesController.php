<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{


    public function create()
    {


        $permissions = Permission::all();
        $user = Auth::user();


        if ($user) {
            $name = $user->first_name;
            return view('roles.create', compact('name', 'permissions'));
        } else {
            return redirect()->route('login');
        }
    }

    public function store(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|unique:roles,name', // Ensure 'name' is unique within the 'roles' table
        'permissions' => 'sometimes|array', // Ensure 'permissions' is an array if provided
        'permissions.*' => 'exists:permissions,id' // Check each permission ID exists in the 'permissions' table
    ]);

    // Create the role with the validated name
    $role = Role::create(['name' => $validated['name']]);

    // If permissions were provided, retrieve them by ID and sync
    if (!empty($validated['permissions'])) {
        $permissions = Permission::whereIn('id', $validated['permissions'])->get();
        $role->syncPermissions($permissions);
    }

    // Redirect with a success message
    return redirect()->route('admin.index')->with('success', 'Role created successfully.');
}

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
{
    // Validate the request data
    $validated = $request->validate([
        'name' => 'required|unique:roles,name,' . $role->id, // Ensure 'name' is unique within the 'roles' table, except for the current role
        'permissions' => 'sometimes|array', // Ensure 'permissions' is an array if provided
        'permissions.*' => 'exists:permissions,id' // Check each permission ID exists in the 'permissions' table
    ]);

    // Update the role with the validated name
    $role->update(['name' => $validated['name']]);

    // Retrieve permissions by ID and sync them to the role
    $permissions = isset($validated['permissions']) ? Permission::whereIn('id', $validated['permissions'])->get() : [];
    $role->syncPermissions($permissions);

    // Redirect with a success message
    return redirect()->route('admin.index')->with('success', 'Role updated successfully.');
}

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.index')->with('success', 'Role deleted successfully.');
    }
}
