<!-- Container div for service selection elements -->
<div>
    <!-- Loop through each service already part of the form or dynamically added -->
    @foreach ($services as $index => $service)
        <!-- Individual service selector block -->
        <div class="service-select">
            <!-- Dropdown menu for selecting a service -->
            <select name="services[]" class="service-select-option">
                <!-- Default option prompting user to select a service -->
                <option value="">Select a Service</option>
                <!-- Loop through all available service options -->
                @foreach ($serviceOptions as $option)
                    <!-- Dropdown option for each service showing the service name and price -->
                    <option value="{{ $option->id }}">{{ $option->name }} - ${{ number_format($option->price, 2) }}</option>
                @endforeach
            </select>
        </div>
    @endforeach
    <!-- Button to trigger addition of another service selector, handled by Livewire -->
    <button type="button" name="submit" wire:click="addService">Add another service</button>
</div>
