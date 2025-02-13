<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $file = $request->file('vtp');
            Storage::disk('api')->put($request->spz.$file->extension(), $file);
            $request->vtp = asset('storage/api/'.$request->spz.$file->extension());
        }

        $vehicle = Vehicle::create($request->except('token'));

        return response()->json($vehicle, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $id): JsonResponse
    {
        if (! Vehicle::exists($id)) {
            return response()->json(['message' => 'Vozidlo nenalezeno'], 404);
        }

        return response()->json(Vehicle::find($id)->toArray());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $id): JsonResponse
    {
        if (! Vehicle::exists($id)) {
            return response()->json(['message' => 'Vozidlo nenalezeno'], 404);
        } else {
            $vehicle = Vehicle::find($id)->update($request->except('token'));

            return response()->json($vehicle);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
