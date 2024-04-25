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
        $name = Auth::user()->first_name;
        $currentMonthProfit = $this->calculateProfitForMonth(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());

        $previousMonthsProfit = $this->calculateProfitForPreviousMonths();

        $recentOngoingProjects = Project::with('employees.user')
            ->where('status', 'ongoing')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recentCompletedProjects = Project::with('employees.user')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $repeatingCostsDetails = RunningCost::where('repeating', true)
            ->whereMonth('date_incurred', Carbon::now()->month)
            ->get();

        $nonRepeatingCostsDetails = RunningCost::where('repeating', false)
            ->whereMonth('date_incurred', Carbon::now()->month)
            ->get();

        $totalRepeatingCosts = $repeatingCostsDetails->sum('cost');
        $totalNonRepeatingCosts = $nonRepeatingCostsDetails->sum('cost');

        return view('manager.index', compact('currentMonthProfit', 'previousMonthsProfit', 'name', 'recentOngoingProjects', 'recentCompletedProjects', 'repeatingCostsDetails', 'nonRepeatingCostsDetails', 'totalRepeatingCosts', 'totalNonRepeatingCosts'));
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

    private function calculateProfitForPreviousMonths()
    {
        $previousMonthsProfit = [];
        for ($i = 1; $i <= 11; $i++) {
            $month = Carbon::now()->subMonths($i)->format('F Y');
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();
            $previousMonthsProfit[$month] = $this->calculateProfitForMonth($startOfMonth, $endOfMonth);
        }
        return $previousMonthsProfit;
    }

}