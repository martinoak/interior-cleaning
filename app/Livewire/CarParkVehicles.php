<?php

namespace App\Livewire;

use App\Enums\VehicleType;
use App\Models\Vehicle;
use Illuminate\View\View;
use Livewire\Component;

class CarParkVehicles extends Component
{
    public ?string $selectedType = null;

    public function mount(): void
    {
        $this->selectedType = null;
    }

    public function render(): View
    {
        $query = Vehicle::query();

        if ($this->selectedType) {
            $query->where('type', $this->selectedType);
        }

        $vehicles = $query->get();

        return view('livewire.car-park-vehicles', [
            'vehicles' => $vehicles,
        ]);
    }
}
