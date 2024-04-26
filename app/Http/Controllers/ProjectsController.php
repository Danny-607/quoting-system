<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quote;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    // Method to display the project index page with all projects and the logged-in user's name.
    public function index(){
        $name = Auth::user()->first_name; // Get the first name of the authenticated user.
        $projects = Project::with('quote.user', 'employees')->get(); // Eager load associated user and employees with projects.

        return view('projects.index', compact('projects', 'name')); // Return the index view with projects and name data.
    }

    // Method to display the form for creating a new project, pre-filled with data from a given quote.
    public function create(Quote $quote){
        $name = Auth::user()->first_name; // Get the first name of the authenticated user.
    
        $quote->load('services', 'user'); // Eager load services and user associated with the quote.
        $employees = Employee::all(); // Retrieve all employees to assign to the project.

        // Prepare initial data for the project based on the quote details.
        $initialData = [
            'quote_id' => $quote->id,
            'user_name' => $quote->user->first_name ?? 'N/A', // Default to 'N/A' if no first name is available.
            'services' => $quote->services->pluck('name')->join(', ') // Create a string of service names.
        ];
    
        return view('projects.create', compact('quote', 'name', 'initialData', 'employees')); // Return the create project view with necessary data.
    }

    // Method to store a newly created project into the database after validation.
    public function store(Request $request)
    {
        // Validate the request data.
        $validated = $request->validate([
            'quote_id' => 'required|exists:quotes,id',
            'start_date' => 'required|date',
            'expected_end_date' => 'required|date',
            'employees' => 'required|array',
            'employees.*' => 'exists:employees,id'
        ]);

        // Find the quote and load its services.
        $quote = Quote::with('services')->findOrFail($validated['quote_id']);
        $servicesCost = $quote->services->sum('cost'); // Calculate the total cost of services.

        $startDate = Carbon::parse($validated['start_date']); // Parse the start date.
        $endDate = Carbon::parse($validated['expected_end_date']); // Parse the expected end date.
        $numberOfWeeks = $startDate->diffInWeeks($endDate);
        $diffInDays = round($startDate->diffInDays($endDate));

        $labourCost = 0;
        foreach ($validated['employees'] as $employeeId) {
            $employee = Employee::findOrFail($employeeId);
            // Calculate the hourly wage based on salary or direct hourly wage.
            $hourlyWage = $employee->wage_type == "salary" ?
                $employee->wage_amount / (52 * $employee->contracted_hours) :
                $employee->wage_amount;

            $nonWorkingDays = 7 - $employee->contracted_days;
            $totalNonWorkingDays = $numberOfWeeks * $nonWorkingDays;
            $totalDaysOnProject = $diffInDays - $totalNonWorkingDays;
            $hoursPerDay = $employee->contracted_hours / $employee->contracted_days;
            $totalHoursOnProject = $totalDaysOnProject * $hoursPerDay;
            $labourCost += $totalHoursOnProject * $hourlyWage;
        }
        $projectCost = $servicesCost + $labourCost; // Calculate the total project cost.
        $projectRevenue = $quote->preliminary_price - $projectCost; // Calculate the project revenue.

        // Create the project in the database.
        $project = Project::create([
            'quote_id' => $validated['quote_id'],
            'start_date' => $validated['start_date'],
            'expected_end_date' => $validated['expected_end_date'],
            'project_cost' => $projectCost,
            'project_revenue' => $projectRevenue
        ]);

        $project->services()->sync($quote->services->pluck('id')); // Link services to the project.
        $project->employees()->sync($validated['employees']); // Assign employees to the project.

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    // Method to display the form for editing an existing project.
    public function edit($id)
    {
        $name = Auth::user()->first_name; // Get the first name of the authenticated user.
        $project = Project::findOrFail($id); // Retrieve the project or fail if not found.

        return view('projects.edit', compact('project', 'name')); // Return the edit project view.
    }

    // Method to update a project's details in the database.
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id); // Retrieve the project or fail if not found.
        
        // Update the project based on the request data.
        $project->update([
            'start_date' => $request->start_date,
            'expected_end_date' => $request->expected_end_date,
            'actual_end_date' => $request->actual_end_date,
            'project_cost' => $request->project_cost,
            'project_revenue' => $request->project_revenue,
            'status' => $request->status,
        ]);
        return redirect()->route('projects.index'); // Redirect back to the project index page.
    }

    // Method to mark a project as complete and update costs and revenue.
    public function complete(Project $project ){
        $actualEndDate = Carbon::today(); // Set the actual end date to today.
        
        // Recalculate the labour cost.
        $quote = $project->quote()->with('services')->firstOrFail();
        $servicesCost = $quote->services->sum('cost');

        $startDate = Carbon::parse($project->start_date);
        $endDate = Carbon::parse($actualEndDate); // Using actual end date now.

        $numberOfWeeks = $startDate->diffInWeeks($endDate);
        $diffInDays = round($startDate->diffInDays($endDate));

        $labourCost = 0;
        foreach ($project->employees as $employee) {
            // Calculate the hourly wage based on the employee's wage type.
            $hourlyWage = $employee->wage_type == "salary" ?
                $employee->wage_amount / (52 * $employee->contracted_hours) :
                $employee->wage_amount;

            $nonWorkingDays = 7 - $employee->contracted_days;
            $totalNonWorkingDays = $numberOfWeeks * $nonWorkingDays;
            $totalDaysOnProject = $diffInDays - $totalNonWorkingDays;
            $hoursPerDay = $employee->contracted_hours / $employee->contracted_days;
            $totalHoursOnProject = $totalDaysOnProject * $hoursPerDay;
            $labourCost += $totalHoursOnProject * $hourlyWage;
        }

        // Update the project costs and revenues based on the recalculated labour costs.
        $projectCost = $servicesCost + $labourCost;
        $projectRevenue = $quote->preliminary_price - $projectCost;

        // Update the project with the recalculated data and mark it as completed.
        $project->update([
            'actual_end_date' => $actualEndDate,
            'status' => 'completed',
            'project_cost' => $projectCost,
            'project_revenue' => $projectRevenue
        ]);

        return redirect()->back()->with('success', 'Project marked as completed and costs updated.');
    }
    
    // Method to delete a project from the database.
    public function destroy(Project $project){
        $project->delete(); // Delete the project.
        return redirect()->route('projects.index'); // Redirect to the project index page.
    }
    
}
