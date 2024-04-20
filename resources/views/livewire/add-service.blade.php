<div>
    @foreach ($services as $index => $service)
        <div class="service-select">
            <select name="services[]" class="service-select-option">
                <option value="">Select a Service</option>
                @foreach ($serviceOptions as $option)
                    <option value="{{ $option->id }}">{{ $option->name }} - ${{ $option->price }}</option>
                @endforeach
            </select>
        </div>
    @endforeach
    <button type="button" name="submit" wire:click="addService">Add another service</button>
</div>
