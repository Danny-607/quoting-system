<?php

namespace App\Http\Controllers;


use App\Models\RunningCost;
use Illuminate\Http\Request;
use App\Models\RunningCostCategory;
use Illuminate\Support\Facades\Auth;

class RunningCostsController extends Controller
{
    // Display a list of all running costs
    public function index(){
        $user = Auth::user(); // Get the currently authenticated user.
        $runningCosts = RunningCost::with('runningCostCategory')->get(); // Retrieve all running costs with their categories.

        if ($user) { // Check if user is authenticated.
            $name = $user->first_name; // Get the first name of the user.
            return view('runningcosts.index', compact('name', 'runningCosts')); // Return the index view with the running costs and user name.
        } else {
            return redirect()->route('login'); // Redirect to login page if no user is authenticated.
        }
    }

    // Show the form for creating a new running cost.
    public function create(){
        $user = Auth::user(); // Get the currently authenticated user.
        $categories = RunningCostCategory::all(); // Retrieve all running cost categories.

        if ($user) { // Check if user is authenticated.
            $name = $user->first_name; // Get the first name of the user.
            return view('runningcosts.create', compact('name', 'categories')); // Return the create view with the categories and user name.
        } else {
            return redirect()->route('login'); // Redirect to login page if no user is authenticated.
        }
    }

    // Store a newly created running cost in the database.
    public function store(Request $request){
        // Validate the request data.
        $validatedData = $request->validate([
            'name' => 'required|string', // The name must be a non-empty string.
            'cost' => 'required|numeric', // The cost must be numeric.
            'date_incurred' => 'required|date', // The date the cost was incurred must be a valid date.
            'category' => 'required|exists:running_cost_categories,id', // The category must exist in the running_cost_categories table.
            'repeating' => 'nullable|boolean', // The repeating flag is optional but must be boolean if provided.
        ]);

        // Create a new RunningCost instance and assign the validated data.
        $runningCost = new RunningCost();
        $runningCost->name = $validatedData['name'];
        $runningCost->cost = $validatedData['cost'];
        $runningCost->date_incurred = $validatedData['date_incurred'];
        $runningCost->running_cost_category_id = $validatedData['category'];  
        $runningCost->repeating = $request->has('repeating'); // Check if repeating flag is present in the request.
        $runningCost->save(); // Save the running cost.

        return redirect()->route('runningcosts.index')->with('success', 'Running cost added successfully!');
    }

    // Show the form for editing the specified running cost.
    public function edit($id){
        $user = Auth::user(); // Get the currently authenticated user.
        $runningCost = RunningCost::findOrFail($id); // Retrieve the running cost or fail if not found.
        $categories = RunningCostCategory::all(); // Retrieve all categories.

        if ($user) { // Check if user is authenticated.
            $name = $user->first_name; // Get the first name of the user.
            return view('runningcosts.edit', compact('name', 'categories', 'runningCost')); // Return the edit view with the running cost, categories, and user name.
        } else {
            return redirect()->route('login'); // Redirect to login page if no user is authenticated.
        }
    }

    // Update the specified running cost in the database.
    public function update($id, Request $request){
        // Validate the incoming data.
        $validatedData = $request->validate([
            'name' => 'required|string', // The name must be a non-empty string.
            'cost' => 'required|numeric', // The cost must be numeric.
            'date_incurred' => 'required|date', // The date the cost was incurred must be a valid date.
            'category_id' => 'required|exists:running_cost_categories,id', // The category must exist in the running_cost_categories table.
            'repeating' => 'nullable|boolean', // The repeating flag is optional but must be boolean if provided.
        ]);

        $runningCost = RunningCost::findOrFail($id); // Retrieve the running cost or fail if not found.
        // Assign the validated data to the running cost.
        $runningCost->name = $validatedData['name'];
        $runningCost->cost = $validatedData['cost'];
        $runningCost->date_incurred = $validatedData['date_incurred'];
        $runningCost->running_cost_category_id = $validatedData['category_id'];
        $runningCost->repeating = $request->has('repeating') ? 1 : 0; // Convert the boolean presence to a numeric value.
        $runningCost->save(); // Save the updated running cost.

        return redirect()->route('runningcosts.index')->with('success', 'Running cost updated successfully');
    }

    // Delete the specified running cost from the database.
    public function destroy($id)
    {
        $runningCost = RunningCost::findOrFail($id); // Retrieve the running cost or fail if not found.
        $runningCost->delete(); // Delete the running cost.

        return redirect()->route('runningcosts.index')->with('success', 'Running cost deleted successfully.');
    }
}