<?php

namespace App\Livewire;
use Illuminate\Support\Str;

use Livewire\Component;

class ShowMoreServices extends Component
{
    public $quote;
    public $showMore = false;

    public function render()
    {
        return view('livewire.show-more-services', [
            'services' => $this->showMore ? $this->quote->services : $this->quote->services->take(3)
        ]);
    }

    public function toggleShowMore()
    {
        $this->showMore = !$this->showMore;
    }
}