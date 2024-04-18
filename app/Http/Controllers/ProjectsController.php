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
    public function index(){
        $name = Auth::user()->first_name;
        $projects = Project::with('quote.user', 'employees')->get();

        return view('projects.index', compact('projects', 'name'));
    
    }

    public function create(Quote $quote){
        $name = Auth::user()->first_name;
    
        $quote->load('services', 'user');
        $employees = Employee::all();
        // dd($quote->load('services', 'name'));
        $initialData = [
            'quote_id' => $quote->id,
            'user_name' => $quote->user->first_name ?? 'N/A',
            'services' => $quote->services->pluck('name')->join(', ')
        ];
    
        return view('projects.create', compact('quote', 'name', 'initialData', 'employees'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'quote_id' => 'required|exists:quotes,id',
        'start_date' => 'required|date',
        'expected_end_date' => 'required|date',
        'employees' => 'required|array',
        'employees.*' => 'exists:employees,id'
    ]);

    $quote = Quote::with('services')->findOrFail($validated['quote_id']);
    $servicesCost = $quote->services->sum('cost');

    $startDate = Carbon::parse($validated['start_date']);
    $endDate = Carbon::parse($validated['expected_end_date']);

    // Define the standard length of a working day
    $hoursPerWorkingDay = 8;
    
    // Calculate the total number of working days
    $totalWorkingDays = $startDate->diffInDays($endDate) + 1; // +1 to include the end day

    $labourCost = 0;

    foreach ($validated['employees'] as $employeeId) {
        $employee = Employee::findOrFail($employeeId);

        // Calculate the total labour hours for each employee
        $employeeTotalHours = $totalWorkingDays * $hoursPerWorkingDay;

        // Calculate labour cost for this employee
        $labourCost += $employee->wage_amount * $employeeTotalHours;
    }

    $projectCost = $servicesCost + $labourCost;
    $projectRevenue = $quote->services->sum('profit') - $projectCost;

    $project = Project::create([
        'quote_id' => $validated['quote_id'],
        'start_date' => $validated['start_date'],
        'expected_end_date' => $validated['expected_end_date'],
        'project_cost' => $projectCost,
        'project_revenue' => $projectRevenue
    ]);

    $project->services()->sync($quote->services->pluck('id'));
    $project->employees()->sync($validated['employees']);

    return redirect()->route('projects.index')->with('success', 'Project created successfully!');
}
    public function edit($id)
    {
        $name = Auth::user()->first_name;
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project', 'name'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $project->update([
            'start_date' => $request->start_date,
            'expected_end_date' => $request->expected_end_date,
            'actual_end_date' => $request->actual_end_date,
            'project_cost' => $request->project_cost,
            'project_revenue' => $request->project_revenue,
            'status' => $request->status,
        ]);
    }

    public function complete(Project $project ){
        $project->update([
            'status' => 'completed',
            'actual_end_date' => Carbon::today()
        ]);
        return redirect()->back()->with('success', 'Project marked as completed.');
    }
    
    public function destroy(){

    }
}
