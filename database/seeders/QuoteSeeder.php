<?php

namespace Database\Seeders;

use App\Models\Quote;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = Service::all();
        $description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ultricies, odio in viverra maximus, tortor turpis molestie quam, non consectetur justo augue quis ligula. Phasellus aliquet volutpat nisl, vitae tincidunt sem lacinia interdum. Sed sed nibh mauris. Nullam ultricies accumsan est, a molestie turpis maximus at. Ut eleifend leo magna, nec laoreet elit sodales quis. Suspendisse consectetur sollicitudin sem sit amet luctus. Aliquam in neque vitae lacus ultrices tincidunt ac sit amet metus. Suspendisse sed neque consectetur, efficitur leo id, elementum elit. Praesent at elit id elit fermentum ullamcorper ac non velit";
        $quote = Quote::create([
            'user_id' => '1', // Assuming user IDs range from 1 to 10
            'description' => $description,
            'preliminary_price' => 1000,
            'approved' => "no",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $selectedServices = $services->random(1,5);

        foreach ($selectedServices as $service) {
            // Attach service to the quote
            $quote->services()->attach($service);
        }
    }
}
