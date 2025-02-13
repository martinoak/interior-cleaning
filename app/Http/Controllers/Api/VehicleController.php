<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Vehicle::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleRequest $request): JsonResponse
    {
        if ($request->hasFile('vtp')) {
            // Get the file from the request
            $file = $request->file('vtp');

            // Generate the filename using $request->spz and the file extension
            $filename = $request->spz.'.'.$file->getClientOriginalExtension();

            // Store the file in the 'api' disk under the 'vtp' directory
            $file->storeAs('vtp', $filename, 'api');
        }

        // Create the Vehicle record with the updated $request data
        $vehicle = Vehicle::create([
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
            'vtp' => $filename ? url()->current().'/vtp/'.$filename : null,
        ]);

        // Return the created vehicle as a JSON response
        return response()->json($vehicle, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle): JsonResponse
    {
        if (!$vehicle) {
            return response()->json(['message' => 'Vozidlo nenalezeno'], 404);
        }

        return response()->json($vehicle);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $id): JsonResponse
    {
        if (!Vehicle::exists($id)) {
            return response()->json(['message' => 'Vozidlo nenalezeno'], 404);
        } else {
            $vehicle = Vehicle::find($id)->update($request->except('token'));

            return response()->json($vehicle);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle): JsonResponse
    {
        $vehicle->delete();

        return response()->json(['message' => 'Vozidlo bylo smazáno'], 200);
    }

    public function serveVTP(string $filename): BinaryFileResponse|JsonResponse
    {
        if (!Storage::disk('api')->exists('vtp/'.$filename)) {
            return response()->json(['message' => 'Soubor nenalezen'], 404);
        } else {
            return response()->file(Storage::disk('api')->path('vtp/'.$filename));
        }
    }
}
