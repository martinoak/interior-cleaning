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
        // Show all vehicles by default (no type selected)
        $this->selectedType = null;
    }

    public function updatedSelectedType(): void
    {
        // This method will be called automatically when selectedType changes
        // No additional logic needed as the render method will handle filtering
    }

    public function render(): View
    {
        $query = Vehicle::query();

        // Filter by selected type if one is selected
        if ($this->selectedType) {
            $query->where('type', $this->selectedType);
        }

        $vehicles = $query->get();

        return view('livewire.car-park-vehicles', [
            'vehicles' => $vehicles,
        ]);
    }
}
