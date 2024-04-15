<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\Project;
use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quoteIds = Quote::pluck('id')->all();

        foreach ($quoteIds as $quoteId) {
            $project = Project::create([
                'quote_id' => $quoteId,
                'start_date' => Carbon::today(),
                'expected_end_date' => Carbon::today()->addDays(rand(10, 100)),
                'actual_end_date' => Carbon::today()->addDays(rand(20, 100)),
                'project_cost' => rand(1000, 5000),
                'project_revenue' => rand(5000, 10000),
                'status' => 'ongoing'
            ]);

            // Attach some employees to the project
            $employees = Employee::inRandomOrder()->limit(rand(1, 5))->get(); // Get random employees
            $project->employees()->attach($employees);
    }
}
}
