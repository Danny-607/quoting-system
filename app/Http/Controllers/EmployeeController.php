<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    // Method to display all employees.
    public function index(){
        $user = Auth::user(); // Authenticate and fetch the logged-in user
        $employees = Employee::all(); // Retrieve all employees from the database
        if ($user) { // Check if the user is authenticated
            $name = $user->first_name; // Retrieve the first name of the user
            $users = User::all(); // Fetch all users from the database
            return view('employee.index', compact('users', 'name', 'employees')); // Return the view with users, name, and employees data
        } else {
            return redirect()->route('login'); // If not logged in, redirect to the login page
        }
    }

    // Method to display the form for creating a new employee.
    public function create(){
        $user = Auth::user(); // Authenticate and fetch the logged-in user
        
        if ($user) { // Check if the user is authenticated
            $name = $user->first_name; // Retrieve the first name of the user
            $users = User::all(); // Fetch all users from the database
            return view('employee.create', compact('users', 'name')); // Return the create view with users and name data
        } else {
            return redirect()->route('login'); // If not logged in, redirect to the login page
        }
    }

    // Method to handle the storage of a newly created employee.
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|exists:users,id', // Validation for user_id existence
            'contracted_hours' => 'required|integer|min:0', // Validation for positive integer contracted hours
            'contracted_days' => 'required|integer|min:0', // Validation for positive integer contracted days
            'wage_type' => 'required|in:hourly,salary', // Validation for wage type (hourly or salary)
            'wages' => 'required|numeric|min:0', // Validation for non-negative wage amount
        ]);

        if ($validator->fails()) { // Check if validation fails
            return redirect()->back()
                ->withErrors($validator) // Send back the errors
                ->withInput(); // With old input
        }
    
        $employee = new Employee(); // Instantiate a new Employee object
        $employee->user_id = $request->input('user_name'); // Assign user ID from the request
        $employee->contracted_hours = $request->input('contracted_hours'); // Assign contracted hours from the request
        $employee->contracted_days = $request->input('contracted_days'); // Assign contracted days from the request
        $employee->wage_type = $request->input('wage_type'); // Assign wage type from the request
        $employee->wage_amount = $request->input('wages'); // Assign wage amount from the request
        $employee->save(); // Save the employee to the database
    
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.'); // Redirect with a success message
    }

    // Method to display the form for editing an existing employee.
    public function edit($id)
    {
        $employee = Employee::findOrFail($id); // Retrieve the employee or fail
        $user = Auth::user(); // Authenticate and fetch the logged-in user
            
        if ($user) { // Check if the user is authenticated
            $name = $user->first_name; // Retrieve the first name of the user
            $users = User::all(); // Fetch all users from the database
            return view('employee.edit', compact('employee', 'users', 'name')); // Return the edit view with employee, users, and name data
        } else {
            return redirect()->route('login'); // If not logged in, redirect to the login page
        }
    }

    // Method to handle the update of an employee's details.
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id); // Retrieve the employee or fail
        
        $request->validate([
            'contracted_hours' => 'required|integer|min:0', // Validation for contracted hours
            'wage_type' => 'required|in:hourly,salary', // Validation for wage type
            'wage_amount' => 'required|numeric|min:0', // Validation for wage amount
        ]);

        $employee->update($request->all()); // Update the employee with new data from the request

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.'); // Redirect with a success message
    }

    // Method to delete an employee from the database.
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id); // Retrieve the employee or fail
        $employee->delete(); // Delete the employee

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.'); // Redirect with a success message
    }
}
