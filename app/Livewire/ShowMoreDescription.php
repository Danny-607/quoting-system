<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class ShowMoreDescription extends Component
{
    public $quote;
    public $showMore = false;
    public $fullDescription;

    public function mount()
    {
        $this->fullDescription = $this->quote->description;
    }

    public function render()
    {
        $description = $this->showMore ? $this->fullDescription : Str::limit($this->fullDescription, 100);

        return view('livewire.show-more-description', [
            'description' => $description
        ]);
    }

    public function toggleShowMore()
    {
        $this->showMore = !$this->showMore;
    }
}