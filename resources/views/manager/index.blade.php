{{-- Extends the main dashboard layout to ensure consistent styling and functionality across the admin interface --}}
@extends('layouts.dashboard')

{{-- Sets the title of the page within the dashboard, which is 'Dashboard' --}}
@section('title', 'Dashboard')

{{-- Begins defining the content section of the page --}}
@section('content')

    {{-- Permission check to ensure only users authorized to view the manager dashboard can access this view --}}
    @can('view manager dashboard')
    
        {{-- Main header for the dashboard --}}
        <h1>Dashboard</h1>

        {{-- Grid container for various dashboard widgets and sections --}}
        <div class="dashboard-grid">
        
            <!-- Profit Section: Displays current and previous months' profits -->
            <div class="profit-section">
                <h2>Profit</h2>
                <h3>Profit for {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                <p>Total Profit: £{{ $currentMonthProfit }}</p>
                <h3>Profit from Previous Months</h3>
                {{-- Loop through each month's profit data and display it --}}
                @foreach ($previousMonthsProfit as $month => $profit)
                    <p>{{ $month }}: £{{ $profit }}</p>
                @endforeach
            </div>

            <!-- Running Costs Section: Displays details about recurring and one-time costs -->
            <div class="runningcost-section">
                <h2>Running Costs</h2>
                <h3>Repeating Costs</h3>
                <ul>
                    {{-- List repeating costs and their amounts --}}
                    @foreach ($repeatingCostsDetails as $cost)
                        <li>{{ $cost->name }}: £{{ number_format($cost->cost, 2) }}</li>
                    @endforeach
                </ul>
                <p><strong>Total Repeating Costs:</strong> £{{ number_format($totalRepeatingCosts, 2) }}</p>

                <h3>Non-Repeating Costs</h3>
                <ul>
                    {{-- List non-repeating costs and their amounts --}}
                    @foreach ($nonRepeatingCostsDetails as $cost)
                        <li>{{ $cost->name }}: £{{ number_format($cost->cost, 2) }}</li>
                    @endforeach
                </ul>
                <p><strong>Total Non-Repeating Costs:</strong> £{{ number_format($totalNonRepeatingCosts, 2) }}</p>
            </div>

            <!-- Ongoing Projects Section: Lists recent ongoing projects with details -->
            <div class="ongoing-projects-section">
                <h2>Ongoing Projects</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Project ID</th>
                            <th>Client</th>
                            <th>Assigned Employees</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through ongoing projects and display relevant details --}}
                        @foreach ($recentOngoingProjects as $project)
                            <tr>
                                <td>{{ $project->quote->id }}</td>
                                <td>{{ $project->quote->user->first_name }} {{ $project->quote->user->last_name }}</td>
                                <td>
                                    <ul>
                                        @foreach ($project->employees as $employee)
                                            <li>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Recently Completed Projects Section: Displays recently completed projects with employee assignments -->
            <div class="completed-projects-section">
                <h2>Recently Completed Projects</h2>
                <table id="manager-table">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Assigned Employees</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through completed projects and display employee details --}}
                        @foreach ($recentCompletedProjects as $project)
                            <tr>
                                <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                                <td>
                                    <ul>
                                        @foreach ($project->employees as $employee)
                                            <li>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    @endcan {{-- Ends the permission check --}}

@endsection {{-- Ends the content section of the blade template --}}
