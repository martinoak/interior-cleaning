<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VehicleController extends Controller
{
    protected Api\VehicleController $api;

    public function __construct(Api\VehicleController $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.vehicles.index', [
            'vehicles' => $this->api->index()->original,
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
        $this->api->store($request);

        return to_route('vehicles.index')->with('success', 'Vozidlo úspěšně vytvořeno');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        return view('admin.vehicles.show', [
            'vehicle' => $this->api->show($id)->original,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
}
