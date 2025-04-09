<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class ServiceLogAttachment extends Component
{
    public int $counter = 1;

    public function addAttachment()
    {
        $this->counter++;
    }

    public function render(): View
    {
        return view('livewire.service-log-attachment', [
            'counter' => $this->counter,
        ]);
    }
}
