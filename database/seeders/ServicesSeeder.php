<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
        [
            'name' => '5 pages',
            'price' => '100',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => '10 pages',
            'price' => '200',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'SEO',
            'price' => '300',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Design',
            'price' => '400',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Hosting',
            'price' => '500',
            'created_at' => now(),
            'updated_at' => now(),
        ]
        ];
        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
