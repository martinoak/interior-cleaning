<?php

namespace App\Livewire;

use App\Enums\VehicleType;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class CarParkVehicles extends Component
{
    private ?VehicleController $api = null;

    public Collection $types;

    public function mount(): void
    {
        $this->types = collect();

        foreach (VehicleType::cases() as $type) {
            $this->types->push($type);
        }
    }

    public function boot(VehicleController $api): void
    {
        $this->api = $api;
    }

    public function refreshTypes(string $type): void
    {
        if ($this->types->contains($type)) {
            $this->types = $this->types->reject($type);
        } else {
            $this->types->push($type);
        }
    }

    public function render(): View
    {
        $vehicles = $this->api->index()->original;

        foreach ($vehicles as $vehicle) {
            if ($this->types->contains($vehicle->type)) {
                $vehicles = $vehicles->reject($vehicle);
            }
        }

        return view('livewire.car-park-vehicles', [
            'vehicles' => $vehicles,
            'types' => $this->types,
        ]);
    }
}
