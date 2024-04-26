<!-- Container div for dynamically selecting employees -->
<div>
    <!-- Loop to dynamically generate multiple select dropdowns based on the number of employees to be added -->
    @for ($i = 0; $i < $employeeCount; $i++)
        <!-- Each select dropdown is wrapped in a div for styling and structure -->
        <div class="employee-select">
            <!-- Select dropdown for choosing an employee -->
            <select name="employees[]">
                <!-- Loop through all available employees and create an option for each one -->
                @foreach ($allEmployees as $employee)
                    <!-- Option value is the employee's ID, and the display text is the employee's first name -->
                    <option value="{{ $employee->id }}">{{ $employee->user->first_name }}</option>
                @endforeach
            </select>
        </div>
    @endfor
    <!-- Button to add another employee to the form; triggers a Livewire component method -->
    <button type="button" class="btn create-btn" wire:click="addEmployee">Add another employee</button>
</div>
