<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CarParkDates;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.vehicles.index', [
            'vehicles' => Vehicle::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request): RedirectResponse
    {
        if ($request->hasFile('vtp')) {
            $file = $request->file('vtp');

            $filename = $request->spz.'.'.$file->getClientOriginalExtension();

            $file->storeAs('vtp', $filename, 'api');
        }

        Vehicle::create([
            'type' => $request->type,
            'manufacturer' => $request->manufacturer,
            'model' => $request->model,
            'productionYear' => $request->productionYear,
            'vin' => $request->vin,
            'spz' => $request->spz,
            'driver' => $request->driver,
            'color' => $request->color,
            'stk' => $request->stk,
            'tachograph' => $request->tachograph,
            'oilChange' => $request->oilChange,
            'insurance' => $request->insurance,
            'vtp' => isset($filename) ? url()->current().'/vtp/'.$filename : null,
            'spneu' => $request->spneu,
            'wpneu' => $request->wpneu,
        ]);

        return to_route('vehicles.index')->with('success', 'Vozidlo úspěšně vytvořeno');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $vehicle = Vehicle::where('id', $id)->firstOrFail();

        return view('admin.vehicles.show', [
            'vehicle' => $vehicle,
            'dates' => CarParkDates::toArray()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $vehicle = Vehicle::where('id', $id)->firstOrFail();

        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $vehicle = Vehicle::where('id', $id)->firstOrFail();

        if ($request->hasFile('vtp')) {
            $file = $request->file('vtp');

            $filename = $request->spz.'.'.$file->getClientOriginalExtension();

            $file->storeAs('vtp', $filename, 'api');
        }

        $vehicle->update([
            'type' => $request->type,
            'manufacturer' => $request->manufacturer,
            'model' => $request->model,
            'productionYear' => $request->productionYear,
            'vin' => $request->vin,
            'spz' => $request->spz,
            'driver' => $request->driver,
            'color' => $request->color,
            'stk' => $request->stk,
            'tachograph' => $request->tachograph,
            'oilChange' => $request->oilChange,
            'insurance' => $request->insurance,
            'spneu' => $request->spneu,
            'wpneu' => $request->wpneu,
        ]);

        if (isset($filename)) {
            $vehicle->update(['vtp' => route('vtp', compact('filename'))]);
        }

        return to_route('vehicles.show', ['vehicle' => $id])->with('success', 'Vozidlo bylo úspěšně aktualizováno.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $vehicle = Vehicle::where('id', $id)->firstOrFail();
        $vehicle->delete();

        return to_route('vehicles.index')->with('success', 'Vozidlo bylo úspěšně smazáno.');
    }

    protected function serveVTP(string $filename): BinaryFileResponse
    {
        if (!Storage::disk('api')->exists('vtp/'.$filename)) {
            abort(404);
        } else {
            return response()->file(Storage::disk('api')->path('vtp/'.$filename));
        }
    }
}
