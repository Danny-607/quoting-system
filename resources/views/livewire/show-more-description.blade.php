<div>
    <p>
        {{ $description }}
        @if (strlen($fullDescription) > 100)
            <button wire:click="toggleShowMore">{{ $showMore ? 'Show less' : 'Show more' }}</button>
        @endif
    </p>
</div>
