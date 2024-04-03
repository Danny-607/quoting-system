<?php

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;

class AddService extends Component
{
    public $services = [];

    public function mount()
    {
        // Initialize with one empty select
        $this->addService();
    }


    public function render()
    {
        
        return view('livewire.add-service', [
            'serviceOptions' => Service::all(), // Pass service options to the view
        ]);
    }
    public function addService()
    {
        $this->services[] = new Service(); // Add a new empty Service object to the $services array
    }
}
