@extends('layouts.dashboard')

@section('content')
<h1>Dashboard</h1>
<div class="dashboard-grid">
    <!-- Profit Section -->
    <div class="profit-section">
        <h2>Profit</h2>
        <h3>Profit for {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
        <p>Total Profit: £{{ $currentMonthProfit }}</p>
        <h3>Profit from Previous Months</h3>
        @foreach($previousMonthsProfit as $month => $profit)
            <p>{{ $month }}: £{{ $profit }}</p>
        @endforeach
    </div>
    <!-- runningcost Section -->
        <!-- Running Costs Section -->
        <div class="runningcost-section">
            <h2>Running Costs</h2>
            <h3>Repeating Costs</h3>
            <ul>
                @foreach($repeatingCostsDetails as $cost)
                    <li>{{ $cost->name }}: £{{ number_format($cost->cost, 2) }}</li>
                @endforeach
            </ul>
            <p><strong>Total Repeating Costs:</strong> £{{ number_format($totalRepeatingCosts, 2) }}</p>
    
            <h3>Non-Repeating Costs</h3>
            <ul>
                @foreach($nonRepeatingCostsDetails as $cost)
                    <li>{{ $cost->name }}: £{{ number_format($cost->cost, 2) }}</li>
                @endforeach
            </ul>
            <p><strong>Total Non-Repeating Costs:</strong> £{{ number_format($totalNonRepeatingCosts, 2) }}</p>
        </div>
    <!-- Ongoing Projects Section -->
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
                @foreach($recentOngoingProjects as $project)
                    <tr>
                        <td>{{ $project->quote->id }}</td>
                        <td>{{$project->quote->user->first_name}} {{$project->quote->user->last_name}}</td>
                        <td>
                            <ul>
                                @foreach($project->employees as $employee)
                                    <li>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recently Completed Projects Section -->
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
                @foreach($recentCompletedProjects as $project)
                    <tr>
                        <td>{{ $employee->user->first_name }} {{ $employee->user->last_name }}</td>
                        <td>
                            <ul>
                                @foreach($project->employees as $employee)
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
@endsection