<div>
    <ul class="services-list">
        @foreach ($services as $service)
            <li>{{ $service->name }}</li>
        @endforeach
    </ul>
    @if ($quote->services->count() > 3)
        <button wire:click="toggleShowMore">{{ $showMore ? 'Show less' : 'Show more' }}</button>
    @endif
</div>