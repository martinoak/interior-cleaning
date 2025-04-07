<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceLogRequest;
use App\Models\ServiceLog;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id): View
    {
        $vehicle = Vehicle::where('id', $id)->firstOrFail();

        return view('admin.vehicles.service-book.index', compact('vehicle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id): View
    {
        $vehicle = Vehicle::where('id', $id)->firstOrFail();

        return view('admin.vehicles.service-book.create', compact('vehicle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceLogRequest $request): RedirectResponse
    {
        ServiceLog::create($request->except('_token'));

        return to_route('service-book.index', ['vehicle' => $request->input('vehicle_id')])->with('success', 'Záznam do knihy byl vytvořen.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // TODO
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $vehicle, string $id): RedirectResponse
    {
        ServiceLog::where('id', $id)->delete();

        return to_route('service-book.index', ['vehicle' => $vehicle])->with('success', 'Záznam byl smazán.');
    }
}
