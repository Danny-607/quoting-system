<div>
    @for ($i = 0; $i < $employeeCount; $i++)
        <div class="employee-select">
            <select name="employees[]">
                @foreach ($allEmployees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->user->first_name }}</option>
                @endforeach
            </select>
        </div>
    @endfor
    <button type="button" class="btn create-btn" wire:click="addEmployee">Add another employee</button>
</div>

