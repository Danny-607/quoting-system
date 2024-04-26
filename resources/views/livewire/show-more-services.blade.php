<!-- Container div for the services list and the show more/less button -->
<div>
    <!-- Unordered list to display the names of services -->
    <ul class="services-list">
        <!-- Loop through each service provided in the $services variable -->
        @foreach ($services as $service)
            <!-- List item for each service displaying its name -->
            <li>{{ $service->name }}</li>
        @endforeach
    </ul>

    <!-- Conditional display of 'Show more' or 'Show less' button based on the number of services -->
    @if ($quote->services->count() > 3)
        <!-- Button that triggers a Livewire component method to toggle the visibility of extended service list -->
        <button wire:click="toggleShowMore">{{ $showMore ? 'Show less' : 'Show more' }}</button>
    @endif
</div>
