<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $employees = Employee::all();
        if ($user) {
            $name = $user->first_name;
            $users = User::all();
            return view('employee.index', compact('users', 'name', 'employees'));
        } else {
            return redirect()->route('login');
        }
    }

    public function create(){
        $user = Auth::user();
        
        if ($user) {
            $name = $user->first_name;
            $users = User::all();
            return view('employee.create', compact('users', 'name'));
        } else {
            return redirect()->route('login');
        }
        
        
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|exists:users,id', // Ensure the selected user exists in the users table
            'contracted_hours' => 'required|integer|min:0', // Ensure contracted hours is a positive integer
            'contracted_days' => 'required|integer|min:0', // Ensure contracted days is a positive integer
            'wage_type' => 'required|in:hourly,salary', // Ensure wage type is either hourly or salary
            'wages' => 'required|numeric|min:0', // Ensure wages is a non-negative number
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // If validation passes, create a new employee record
        $employee = new Employee();
        $employee->user_id = $request->input('user_name');
        $employee->contracted_hours = $request->input('contracted_hours');
        $employee->contracted_days = $request->input('contracted_days');
        $employee->wage_type = $request->input('wage_type');
        $employee->wage_amount = $request->input('wages');
        $employee->save();
    
        // Redirect to a success page or route
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit($id)
{
    $employee = Employee::findOrFail($id);
    $user = Auth::user();
        
        if ($user) {
            $name = $user->first_name;
            $users = User::all();
            return view('employee.edit', compact('employee', 'users', 'name'));
        } else {
            return redirect()->route('login');
        }
}

public function update(Request $request, $id)
{
    $employee = Employee::findOrFail($id);
    
    // Validate incoming request data
    $request->validate([
        'contracted_hours' => 'required|integer|min:0', // Ensure contracted hours is a positive integer
        'wage_type' => 'required|in:hourly,salary', // Ensure wage type is either hourly or salary
        'wage_amount' => 'required|numeric|min:0', // Ensure wages is a non-negative number
    ]);

    // Update the employee record with the new data
    $employee->update($request->all());

    // Redirect to a success page or route
    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}

public function destroy($id)
{
    $employee = Employee::findOrFail($id);
    $employee->delete();

    // Redirect to a success page or route
    return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
}
}
