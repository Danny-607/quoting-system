<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\RunningCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    // Method to display the main manager dashboard view.
    public function index()
    {
        // Retrieve the first name of the currently authenticated user.
        $name = Auth::user()->first_name;
        // Calculate the current month's profit using a private method that takes the start and end of the month.
        $currentMonthProfit = $this->calculateProfitForMonth(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());

        // Calculate profits for the previous 11 months.
        $previousMonthsProfit = $this->calculateProfitForPreviousMonths();

        // Retrieve the most recent 5 ongoing projects with associated employee and user details.
        $recentOngoingProjects = Project::with('employees.user')
            ->where('status', 'ongoing')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Retrieve the most recent 5 completed projects with associated employee and user details.
        $recentCompletedProjects = Project::with('employees.user')
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Fetch details of all repeating costs incurred this month.
        $repeatingCostsDetails = RunningCost::where('repeating', true)
            ->whereMonth('date_incurred', Carbon::now()->month)
            ->get();

        // Fetch details of all non-repeating costs incurred this month.
        $nonRepeatingCostsDetails = RunningCost::where('repeating', false)
            ->whereMonth('date_incurred', Carbon::now()->month)
            ->get();

        // Calculate the total costs for repeating and non-repeating categories.
        $totalRepeatingCosts = $repeatingCostsDetails->sum('cost');
        $totalNonRepeatingCosts = $nonRepeatingCostsDetails->sum('cost');

        // Return the manager dashboard view with all the prepared data.
        return view('manager.index', compact('currentMonthProfit', 'previousMonthsProfit', 'name', 'recentOngoingProjects', 'recentCompletedProjects', 'repeatingCostsDetails', 'nonRepeatingCostsDetails', 'totalRepeatingCosts', 'totalNonRepeatingCosts'));
    }

    // Private method to calculate profit for a given date range.
    private function calculateProfitForMonth($startDate, $endDate)
    {
        // Fetch all projects that ended within the specified date range.
        $projects = Project::whereBetween('actual_end_date', [$startDate, $endDate])->get();

        // Initialize total profit.
        $totalProfit = 0;
        // Calculate total profit by summing the project revenues.
        foreach ($projects as $project) {
            $totalProfit += $project->project_revenue;
        }

        // Return the total profit calculated.
        return $totalProfit;
    }

    // Private method to calculate profits for the previous 11 months.
    private function calculateProfitForPreviousMonths()
    {
        $previousMonthsProfit = [];
        // Loop through the last 11 months.
        for ($i = 1; $i <= 11; $i++) {
            // Format the month for display.
            $month = Carbon::now()->subMonths($i)->format('F Y');
            // Calculate the start and end of each month.
            $startOfMonth = Carbon::now()->subMonths($i)->startOfMonth();
            $endOfMonth = Carbon::now()->subMonths($i)->endOfMonth();
            // Store the profit for each month using the method that calculates profit for a given range.
            $previousMonthsProfit[$month] = $this->calculateProfitForMonth($startOfMonth, $endOfMonth);
        }
        // Return the calculated profits for each of the previous months.
        return $previousMonthsProfit;
    }

}
