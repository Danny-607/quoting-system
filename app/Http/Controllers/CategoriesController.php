<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\RunningCostCategory;

class CategoriesController extends Controller
{
    // Define a method to handle the creation view of categories.
    public function create()
    {
        // Retrieve the currently authenticated user using Laravel's helper function.
        $user = auth()->user();
        
        // Check if a user is authenticated.
        if ($user) {
            // Retrieve the first name of the authenticated user.
            $name = $user->first_name;
            // Return the create category view and pass the first name to the view.
            return view('categories.create', compact('name'));
        } else {
            // If no user is authenticated, redirect to the login page.
            return redirect()->route('login');
        }
        
    }

    // Define a method to handle the storing of a new category.
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $request->validate([
            'name' => 'required|string|max:255',           // Ensure 'name' is a required string with a max length of 255 characters.
            'type' => 'required|in:service,running_cost', // Ensure 'type' is required and must be either 'service' or 'running_cost'.
        ]);

        // Check if the category type from the request is 'service'.
        if ($request->type === 'service') {
            // Create a new ServiceCategory record with the name provided in the request.
            ServiceCategory::create(['name' => $request->name]);
            // Redirect to the service categories index page with a success message.
            return redirect()->route('services.index')->with('success', 'Category created successfully.');
        } elseif ($request->type === 'running_cost') {
            // Create a new RunningCostCategory record with the name provided in the request.
            RunningCostCategory::create(['name' => $request->name]);
            // Redirect to the running costs categories index page with a success message.
            return redirect()->route('runningcosts.index')->with('success', 'Category created successfully.');
        }
        
    }
}
