<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Services\MapService;
use App\Services\OniSystemService;
use Barryvdh\DomPDF\Facade\Pdf;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OniController extends Controller
{
    private OniSystemService $oni;
    private MapService $mapService;

    public function __construct(OniSystemService $oni, MapService $mapService)
    {
        $this->oni = $oni;
        $this->mapService = $mapService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        try {
            $vehicles = $this->oni->getParsedVehicleList();

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
     *
     * @throws GuzzleException
     */
    public function show(string $id): View|RedirectResponse
    {
        try {
            $from = request('start_date', date('c', strtotime('-1 month'))).'T00:00:00';
            $to = request('end_date', date('c')).'T23:59:59';

            $vehicle = Vehicle::where('oni_id', $id)->first();
            if (!$vehicle) {
                return back()->with('error', 'Vozidlo nemá přiřazené ONI ID!');
            }
            $rides = $this->oni->getParsedRideHistory($id, $from, $to);

            // Group rides by date and sort chronologically
            $grouped = collect($rides)->groupBy(function ($ride) {
                // Extract date from STARTTIME (format: "04.09.25 15:16:13")
                $startTime = $ride['STARTTIME'];
                if (preg_match('/^(\d{2}\.\d{2}\.\d{2})/', $startTime, $matches)) {
                    return $matches[1]; // Returns date like "04.09.25"
                }

                return 'Unknown Date';
            });

            // Sort the grouped collection by actual date values
            $ridesByDate = $grouped->sortBy(function ($rides, $dateString) {
                // Convert date string to sortable format
                // "04.09.25" -> "2025-09-04" for proper sorting
                if (preg_match('/^(\d{2})\.(\d{2})\.(\d{2})$/', $dateString, $matches)) {
                    $day = $matches[1];
                    $month = $matches[2];
                    $year = '20'.$matches[3]; // Convert 25 to 2025

                    return $year.'-'.$month.'-'.$day;
                }

                return $dateString;
            });

            return view('admin.oni.show', compact('vehicle', 'ridesByDate', 'id'));
        } catch (GuzzleException|\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Export ride history for a specific date as PDF
     */
    public function export(string $id): Response
    {
        try {
            $date = request('date');

            $vehicle = Vehicle::where('oni_id', $id)->first();
            $rides = $this->oni->getParsedRideHistory($id, $date.'T00:00:00', $date.'T23:59:59');

            // Generate map image using MapService
            $mapImage = $this->mapService->generateMapImageForPdf($rides, 600, 400);

            $pdf = Pdf::loadView('admin.oni.pdf-export', [
                'vehicle' => $vehicle,
                'rides' => $rides,
                'date' => $date ?: 'Všechny záznamy',
                'mapImage' => $mapImage,
            ]);

            $filename = 'stazka_'.$vehicle->spz.'.pdf';

            return $pdf->download($filename);
        } catch (GuzzleException|\Exception $e) {
            return response('Error generating export: '.$e->getMessage(), 500);
        }
    }

    /**
     * Show interactive map preview for ride history
     */
    public function showMap(string $id): View|Response
    {
        try {
            $date = request('date');
            $vehicle = Vehicle::where('oni_id', $id)->first();
            $rides = $this->oni->getParsedRideHistory($id, $date.'T00:00:00', $date.'T23:59:59');

            return view('admin.oni.map-preview', [
                'vehicle' => $vehicle,
                'rides' => $rides,
                'date' => $date,
                'id' => $id,
            ]);
        } catch (GuzzleException|\Exception $e) {
            return response('Error loading map: '.$e->getMessage(), 500);
        }
    }


}
