@extends('admin/layout')

@section('head')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap"></script>
@endsection

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto">
            <h1 class="heading-title">Detail jízdy {{ DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') }} vozidla {{ $vehicle->spz ?? 'Vozidlo '.$id }}</h1>
        </div>
        <div class="sm:mt-0 sm:ml-16 sm:flex-none space-x-3">
            <a href="{{ route('oni.show', ['oni' => $id, 'date' => $date]) }}"
               class="inline-flex items-center rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500">
                ← Zpět na seznam jízd
            </a>
            <a href="{{ route('oni.export', ['oni' => $id, 'date' => $date]) }}"
               class="inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500">
                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z"></path>
                </svg>
                Stáhnout PDF
            </a>
        </div>
    </div>

    @if(count($rides) > 0)
        <!-- Interactive Map Display -->
        <div class="mt-8">
            <div class="mb-4">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Mapa tras</h2>
            </div>

            <div id="map" style="height: 500px; width: 100%; border-radius: 8px; border: 1px solid #d1d5db;"></div>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                Interaktivní mapa zobrazuje všechny trasy s polylines a číslovanými body startu a konce každé jízdy.
            </p>
        </div>

        <!-- Rides Summary -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Souhrn jízd</h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ count($rides) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Celkem jízd</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ number_format(collect($rides)->sum('DRIVEDIST'), 1) }} km
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Celková vzdálenost</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ number_format(collect($rides)->avg('VEAVG'), 1) }} km/h
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Prům. rychlost</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ collect($rides)->max('VEMAX') }} km/h
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Max. rychlost</div>
                </div>
            </div>
        </div>

        <!-- Rides List -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Detail jízd</h2>

            <div class="overflow-x-auto">

                <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">#</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Začátek</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Konec</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Vzdálenost</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Trasa</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                        @foreach($rides as $index => $ride)
                            <tr>
                                <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">
                                    <div class="flex items-center">
                                        <div class="w-6 h-6 rounded-full bg-red-500 text-white text-xs font-bold flex items-center justify-center">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                    <div>{{ $ride['STARTTIME'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $ride['STARTOBEC'] }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                    <div>{{ $ride['STOPTIME'] }}</div>
                                    <div class="text-xs text-gray-500">{{ $ride['STOPOBEC'] }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                    {{ $ride['DRIVEDIST'] }} km
                                </td>
                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                    {{ $ride['STARTOBEC'] }} → {{ $ride['STOPOBEC'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="mt-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Žádné jízdy</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Pro vybraný datum nebyly nalezeny žádné jízdy.
            </p>
        </div>
    @endif
</div>

<script>
let map;
let polylines = [];
let markers = [];

// Ride data from PHP
const rides = @json($rides);

function initMap() {
    console.log('initMap called');
    console.log('Rides data:', rides);

    // Initialize map
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: 49.75, lng: 15.5 }, // Default center (Czech Republic)
        mapTypeId: "roadmap",
        styles: [
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [{ visibility: "off" }]
            }
        ]
    });

    console.log('Map initialized');

    if (rides.length === 0) {
        console.log('No rides data available');
        return;
    }

    console.log('Processing', rides.length, 'rides');

    const bounds = new google.maps.LatLngBounds();

    rides.forEach((ride, index) => {
        const startLat = parseFloat(ride.STARTGPSLA?.replace(',', '.') || 0);
        const startLng = parseFloat(ride.STARTGPSLO?.replace(',', '.') || 0);
        const stopLat = parseFloat(ride.STOPGPSLA?.replace(',', '.') || 0);
        const stopLng = parseFloat(ride.STOPGPSLO?.replace(',', '.') || 0);

        if (startLat === 0 || startLng === 0 || stopLat === 0 || stopLng === 0) {
            return;
        }

        const startPos = { lat: startLat, lng: startLng };
        const stopPos = { lat: stopLat, lng: stopLng };
        const color = '#2563eb';

        // Create polyline for the route
        const polyline = new google.maps.Polyline({
            path: [startPos, stopPos],
            geodesic: true,
            strokeColor: color,
            strokeOpacity: 1.0,
            strokeWeight: 3,
        });

        polyline.setMap(map);
        polylines.push(polyline);

        // Add start marker
        const startMarker = new google.maps.Marker({
            position: startPos,
            map: map,
            title: `Jízda ${index + 1} - Start: ${ride.STARTOBEC}`,
            label: {
                text: (index + 1).toString(),
                color: 'white',
                fontWeight: 'bold'
            },
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: color,
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 2,
                scale: 12
            }
        });

        // Add end marker
        const endMarker = new google.maps.Marker({
            position: stopPos,
            map: map,
            title: `Jízda ${index + 1} - Konec: ${ride.STOPOBEC}`,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: color,
                fillOpacity: 0.7,
                strokeColor: 'white',
                strokeWeight: 2,
                scale: 8
            }
        });

        markers.push(startMarker, endMarker);

        // Extend bounds
        bounds.extend(startPos);
        bounds.extend(stopPos);

        // Add info windows
        const startInfoWindow = new google.maps.InfoWindow({
            content: `
                <div style="font-size: 12px;">
                    <strong>Jízda ${index + 1} - Start</strong><br>
                    Čas: ${ride.STARTTIME}<br>
                    Místo: ${ride.STARTOBEC}<br>
                    Vzdálenost: ${ride.DRIVEDIST} km
                </div>
            `
        });

        const endInfoWindow = new google.maps.InfoWindow({
            content: `
                <div style="font-size: 12px;">
                    <strong>Jízda ${index + 1} - Konec</strong><br>
                    Čas: ${ride.STOPTIME}<br>
                    Místo: ${ride.STOPOBEC}
                </div>
            `
        });

        startMarker.addListener('click', () => {
            startInfoWindow.open(map, startMarker);
        });

        endMarker.addListener('click', () => {
            endInfoWindow.open(map, endMarker);
        });
    });

    // Fit map to show all routes
    if (!bounds.isEmpty()) {
        map.fitBounds(bounds);

        // Add some padding
        google.maps.event.addListenerOnce(map, 'bounds_changed', function() {
            if (map.getZoom() > 15) {
                map.setZoom(15);
            }
        });
    }

}

// Make initMap available globally
window.initMap = initMap;
</script>

@endsection
