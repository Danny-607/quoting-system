<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Bills', 
        ]);
        Category::create([
            'name' => 'Subscriptions', 
        ]);
        Category::create([
            'name' => 'Software', 
        ]);
        Category::create([
            'name' => 'Hardware', 
        ]);
        Category::create([
            'name' => 'Miscellaneous', 
        ]);
    }
}
