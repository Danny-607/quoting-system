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
            'service_category_id' => '1',
            'name' => '5 pages',
            'cost' => '50',
            'price' => '100',
            'profit' => '50',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'service_category_id' => '1',
            'name' => '10 pages',
            'cost' => '50',
            'price' => '200',
            'profit' => '150',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'service_category_id' => '2',
            'name' => 'SEO',
            'cost' => '50',
            'price' => '300',
            'profit' => '250',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'service_category_id' => '3',
            'name' => 'Design',
            'cost' => '50',
            'price' => '400',
            'profit' => '350',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'service_category_id' => '4',
            'name' => 'Hosting',
            'cost' => '50',
            'price' => '500',
            'profit' => '450',
            'created_at' => now(),
            'updated_at' => now(),
        ]
        ];
        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}
