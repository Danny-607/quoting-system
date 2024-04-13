<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee;

class AddEmployee extends Component
{
    public $employees = [];
    public $employeeCount = 1;

    public function mount()
    {
        $this->employees = Employee::all();  // Load all employees from the database
    }

    public function addEmployee()
    {
        $this->employeeCount++;  // Increment to add a new select field
    }

    public function render()
    {
        return view('livewire.add-employee', [
            'allEmployees' => $this->employees  // Pass employees to the view
        ]);
    }
}
