@extends('layouts.dashboard')

@section('content')
<h2>Manager's Dashboard</h2>

<h3>Profit for {{ \Carbon\Carbon::now()->format('F Y') }}</h3>
        <!-- Display profit for the current month here -->
        <p>Total Profit: £{{ $currentMonthProfit }}</p>

        <h3>Profit from Previous Months</h3>
        <!-- Display profit from previous months here -->
        @foreach($previousMonthsProfit as $month => $profit)
            <p>{{ $month }}: £{{ $profit }}</p>
        @endforeach
    </div>

    <h3>Recent Ongoing Projects and Assigned Employees</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Assigned Employees</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOngoingProjects as $project)
                    <tr>
                        <td>{{ $project->quote->user->name }}</td>
                        <td>
                            <ul>
                                @foreach($project->employees as $employee)
                                    <li>{{ $employee->user->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Recent Completed Projects and Assigned Employees</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Assigned Employees</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentCompletedProjects as $project)
                    <tr>
                        <td>{{ $project->quote->user->name }}</td>
                        <td>
                            <ul>
                                @foreach($project->employees as $employee)
                                    <li>{{ $employee->user->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <h3>This Months Running Costs</h3>
    <p>Repeating Costs: £{{ $repeatingCosts }}</p>
    <p>Non-Repeating Costs: £{{ $nonRepeatingCosts }}</p>
</div>
@endsection