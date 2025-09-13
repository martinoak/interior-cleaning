<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OniSystemService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        $oniService = new OniSystemService;

        try {
            $vehicles = $oniService->getParsedVehicleList();

            return view('admin.oni.index', compact('vehicles'));
        } catch (GuzzleException|\Exception $e) {
            return view('admin.oni.index', [
                'vehicles' => [],
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        //
    }
}
