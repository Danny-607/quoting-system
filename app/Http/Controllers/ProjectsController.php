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
    // Project cost 
    $servicesCost = $quote->services->sum('cost');

    $startDate = Carbon::parse($validated['start_date']);
    $endDate = Carbon::parse($validated['expected_end_date']);

    $numberOfWeeks = $startDate->diffInWeeks($endDate);
    $diffInDays = round($startDate->diffInDays($endDate));

    $labourCost = 0;
        foreach ($validated['employees'] as $employeeId) {
            $employee = Employee::findOrFail($employeeId);
            if($employee->wage_type == "salary"){
                $hourlyWage = $employee->wage_amount/(52*$employee->contracted_hours) ;
            }else{
                $hourlyWage = $employee->wage_amount;
            }

            $nonWorkingDays = 7 - $employee->contracted_days;
            $totalNonWorkingDays = $numberOfWeeks * $nonWorkingDays;
            $totalDaysOnProject = $diffInDays - $totalNonWorkingDays;
            $a = $employee->contracted_hours/$employee->contracted_days;
            $totalHoursOnProject = $totalDaysOnProject * $a;
            $labourCost += $totalHoursOnProject * $hourlyWage;
        }
    $projectCost = $servicesCost + $labourCost;
    
    $projectRevenue = $quote->preliminary_price - $projectCost;

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
        return redirect()->route('projects.index');
    }

    public function complete(Project $project ){
    $actualEndDate = Carbon::today();
    
    // Recalculate the labour cost
    $quote = $project->quote()->with('services')->firstOrFail();
    $servicesCost = $quote->services->sum('cost');

    $startDate = Carbon::parse($project->start_date);
    $endDate = Carbon::parse($actualEndDate); // Using actual end date now

    $numberOfWeeks = $startDate->diffInWeeks($endDate);
    $diffInDays = round($startDate->diffInDays($endDate));

    $labourCost = 0;
    foreach ($project->employees as $employee) {
        if ($employee->wage_type == "salary") {
            $hourlyWage = $employee->wage_amount / (52 * $employee->contracted_hours);
        } else {
            $hourlyWage = $employee->wage_amount;
        }

        $nonWorkingDays = 7 - $employee->contracted_days;
        $totalNonWorkingDays = $numberOfWeeks * $nonWorkingDays;
        $totalDaysOnProject = $diffInDays - $totalNonWorkingDays;
        $hoursPerDay = $employee->contracted_hours / $employee->contracted_days;
        $totalHoursOnProject = $totalDaysOnProject * $hoursPerDay;
        $labourCost += $totalHoursOnProject * $hourlyWage;
    }

    // Update the project costs and revenues based on the recalculated labour costs
    $projectCost = $servicesCost + $labourCost;
    $projectRevenue = $quote->preliminary_price - $projectCost;

    // Update the project with the recalculated data and mark it as completed
    $project->update([
        'actual_end_date' => $actualEndDate,
        'status' => 'completed',
        'project_cost' => $projectCost,
        'project_revenue' => $projectRevenue
    ]);

    return redirect()->back()->with('success', 'Project marked as completed and costs updated.');
    }
    
    public function destroy(Project $project){
        $project->delete();
        return redirect()->route('projects.index');
    }
    
}
