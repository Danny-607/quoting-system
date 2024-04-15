<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\RunningCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        $username = Auth::user()->name;
        // Calculate profit for the current month
        $currentMonthProfit = $this->calculateProfitForMonth(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());

        // Calculate profit for previous months
        $previousMonthsProfit = [];
        for ($i = 1; $i <= 11; $i++) { 
            $month = Carbon::now()->subMonths($i)->format('F Y');
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();
            $previousMonthsProfit[$month] = $this->calculateProfitForMonth($startOfMonth, $endOfMonth);
        }
        $recentOngoingProjects = Project::with('employees.user')
            ->where('status', 'ongoing')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Retrieve the 5 most recent completed projects and their assigned employees
        $recentCompletedProjects = Project::with('employees.user')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $repeatingCosts = RunningCost::where('repeating', true)
        ->whereMonth('date_incurred', now()->month)
        ->sum('cost');

        // Calculate total non-repeating costs for the current month
        $nonRepeatingCosts = RunningCost::where('repeating', false)
            ->whereMonth('date_incurred', now()->month)
            ->sum('cost');

        return view('manager.index', compact('currentMonthProfit', 'previousMonthsProfit', 'username', 'recentOngoingProjects','recentCompletedProjects', 'repeatingCosts', 'nonRepeatingCosts'));
    }

    private function calculateProfitForMonth($startDate, $endDate)
    {
        $projects = Project::whereBetween('actual_end_date', [$startDate, $endDate])->get();

        $totalProfit = 0;
        foreach ($projects as $project) {
            $totalProfit += $project->project_revenue;
        }

        return $totalProfit;
    }
}