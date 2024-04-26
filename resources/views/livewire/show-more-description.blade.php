<!-- Container div for the description and toggle button -->
<div>
    <!-- Paragraph tag that contains the dynamic description -->
    <p>
        {{ $description }} <!-- Displays the description variable content -->
        
        <!-- Conditional statement to check if the length of the full description exceeds 100 characters -->
        @if (strlen($fullDescription) > 100)
            <!-- Button that toggles the display length of the description. The action is handled by Livewire's toggleShowMore method -->
            <button wire:click="toggleShowMore">
                <!-- Dynamically changes the button text based on the state of $showMore -->
                {{ $showMore ? 'Show less' : 'Show more' }}
            </button>
        @endif
    </p>
</div>
