<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(ManagerSeeder::class);
        $this->call(RunningCostCategorySeeder::class);
        $this->call(ServiceCategorySeeder::class);
        $this->call(ServicesSeeder::class);
        $this->call(QuoteSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(RunningCostsSeeder::class);
        $this->call(ProjectsTableSeeder::class);
    }
}
