<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MapService
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 30,
            'connect_timeout' => 10,
        ]);
    }

    /**
     * Generate a static map image with routes for rides using Google Maps Static API
     */
    public function generateStaticMapWithRoutes(array $rides, int $width = 800, int $height = 600): ?string
    {
        if (empty($rides)) {
            return null;
        }

        try {
            // Try Google Maps Static API first
            $googleMapUrl = $this->buildGoogleStaticMapUrl($rides, $width, $height);

            if ($googleMapUrl) {
                // Download the map image from Google
                $response = $this->client->get($googleMapUrl);
                if ($response->getStatusCode() === 200) {
                    return $response->getBody()->getContents();
                }
            }

            // Fallback to SVG map if Google Maps fails
            $bounds = $this->calculateBounds($rides);
            return $this->generateSvgMap($rides, $bounds, $width, $height);

        } catch (\Exception $e) {
            \Log::error('Map generation failed: ' . $e->getMessage());

            // Fallback to SVG map
            $bounds = $this->calculateBounds($rides);
            return $this->generateSvgMap($rides, $bounds, $width, $height);
        }
    }

    /**
     * Calculate bounds for all GPS coordinates
     */
    private function calculateBounds(array $rides): array
    {
        $lats = [];
        $lons = [];

        foreach ($rides as $ride) {
            if (!empty($ride['STARTGPSLA']) && !empty($ride['STARTGPSLO'])) {
                $lats[] = (float) str_replace(',', '.', $ride['STARTGPSLA']);
                $lons[] = (float) str_replace(',', '.', $ride['STARTGPSLO']);
            }
            if (!empty($ride['STOPGPSLA']) && !empty($ride['STOPGPSLO'])) {
                $lats[] = (float) str_replace(',', '.', $ride['STOPGPSLA']);
                $lons[] = (float) str_replace(',', '.', $ride['STOPGPSLO']);
            }
        }

        if (empty($lats) || empty($lons)) {
            return ['minLat' => 0, 'maxLat' => 0, 'minLon' => 0, 'maxLon' => 0];
        }

        return [
            'minLat' => min($lats),
            'maxLat' => max($lats),
            'minLon' => min($lons),
            'maxLon' => max($lons),
        ];
    }

    /**
     * Generate SVG map with routes (fallback solution)
     */
    private function generateSvgMap(array $rides, array $bounds, int $width, int $height): string
    {
        $padding = 20;
        $mapWidth = $width - (2 * $padding);
        $mapHeight = $height - (2 * $padding);

        // Calculate scale
        $latRange = $bounds['maxLat'] - $bounds['minLat'];
        $lonRange = $bounds['maxLon'] - $bounds['minLon'];

        if ($latRange == 0) $latRange = 0.01;
        if ($lonRange == 0) $lonRange = 0.01;

        $svg = '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">';

        // Background
        $svg .= '<rect width="' . $width . '" height="' . $height . '" fill="#f0f8ff" stroke="#ccc" stroke-width="1"/>';

        // Grid lines
        for ($i = 0; $i <= 10; $i++) {
            $x = $padding + ($i * $mapWidth / 10);
            $y = $padding + ($i * $mapHeight / 10);
            $svg .= '<line x1="' . $x . '" y1="' . $padding . '" x2="' . $x . '" y2="' . ($height - $padding) . '" stroke="#e0e0e0" stroke-width="0.5"/>';
            $svg .= '<line x1="' . $padding . '" y1="' . $y . '" x2="' . ($width - $padding) . '" y2="' . $y . '" stroke="#e0e0e0" stroke-width="0.5"/>';
        }

        // Draw routes
        $colors = ['#ff4444', '#44ff44', '#4444ff', '#ffaa00', '#aa00ff', '#00aaff'];
        $colorIndex = 0;

        foreach ($rides as $index => $ride) {
            $startLat = (float) str_replace(',', '.', $ride['STARTGPSLA'] ?? '0');
            $startLon = (float) str_replace(',', '.', $ride['STARTGPSLO'] ?? '0');
            $stopLat = (float) str_replace(',', '.', $ride['STOPGPSLA'] ?? '0');
            $stopLon = (float) str_replace(',', '.', $ride['STOPGPSLO'] ?? '0');

            if ($startLat == 0 || $startLon == 0 || $stopLat == 0 || $stopLon == 0) {
                continue;
            }

            // Convert GPS to SVG coordinates
            $startX = $padding + (($startLon - $bounds['minLon']) / $lonRange) * $mapWidth;
            $startY = $height - $padding - (($startLat - $bounds['minLat']) / $latRange) * $mapHeight;
            $stopX = $padding + (($stopLon - $bounds['minLon']) / $lonRange) * $mapWidth;
            $stopY = $height - $padding - (($stopLat - $bounds['minLat']) / $latRange) * $mapHeight;

            $color = $colors[$colorIndex % count($colors)];
            $colorIndex++;

            // Draw route line
            $svg .= '<line x1="' . $startX . '" y1="' . $startY . '" x2="' . $stopX . '" y2="' . $stopY . '" stroke="' . $color . '" stroke-width="3" opacity="0.8"/>';

            // Draw start point
            $svg .= '<circle cx="' . $startX . '" cy="' . $startY . '" r="5" fill="' . $color . '" stroke="white" stroke-width="2"/>';

            // Draw end point
            $svg .= '<circle cx="' . $stopX . '" cy="' . $stopY . '" r="5" fill="' . $color . '" stroke="white" stroke-width="2"/>';

            // Add route number
            $midX = ($startX + $stopX) / 2;
            $midY = ($startY + $stopY) / 2;
            $svg .= '<circle cx="' . $midX . '" cy="' . $midY . '" r="10" fill="white" stroke="' . $color . '" stroke-width="2"/>';
            $svg .= '<text x="' . $midX . '" y="' . ($midY + 3) . '" text-anchor="middle" font-family="Arial" font-size="10" font-weight="bold" fill="' . $color . '">' . ($index + 1) . '</text>';
        }

        // Add legend
        $legendY = $height - 60;
        $svg .= '<rect x="10" y="' . ($legendY - 10) . '" width="200" height="50" fill="white" stroke="#ccc" stroke-width="1" opacity="0.9"/>';
        $svg .= '<text x="15" y="' . ($legendY + 5) . '" font-family="Arial" font-size="10" font-weight="bold">Legenda:</text>';
        $svg .= '<circle cx="25" cy="' . ($legendY + 20) . '" r="3" fill="#ff4444"/>';
        $svg .= '<text x="35" y="' . ($legendY + 24) . '" font-family="Arial" font-size="9">Start/Konec jízdy</text>';
        $svg .= '<circle cx="25" cy="' . ($legendY + 35) . '" r="6" fill="white" stroke="#ff4444" stroke-width="1"/>';
        $svg .= '<text x="20" y="' . ($legendY + 39) . '" font-family="Arial" font-size="8" font-weight="bold" fill="#ff4444">1</text>';
        $svg .= '<text x="35" y="' . ($legendY + 39) . '" font-family="Arial" font-size="9">Číslo jízdy</text>';

        $svg .= '</svg>';

        return $svg;
    }

    /**
     * Build Google Maps Static API URL with polylines for routes
     */
    private function buildGoogleStaticMapUrl(array $rides, int $width, int $height): ?string
    {
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        if (!$apiKey) {
            \Log::warning('Google Maps API key not found in environment');
            return null;
        }

        $baseUrl = 'https://maps.googleapis.com/maps/api/staticmap';
        $params = [
            'size' => $width . 'x' . $height,
            'maptype' => 'roadmap',
            'format' => 'png',
            'key' => $apiKey,
        ];

        $markers = [];
        $paths = [];
        $allCoords = [];

        foreach ($rides as $index => $ride) {
            $startLat = str_replace(',', '.', $ride['STARTGPSLA'] ?? '');
            $startLon = str_replace(',', '.', $ride['STARTGPSLO'] ?? '');
            $stopLat = str_replace(',', '.', $ride['STOPGPSLA'] ?? '');
            $stopLon = str_replace(',', '.', $ride['STOPGPSLO'] ?? '');

            if (empty($startLat) || empty($startLon) || empty($stopLat) || empty($stopLon)) {
                continue;
            }

            // Collect all coordinates for auto-centering
            $allCoords[] = $startLat . ',' . $startLon;
            $allCoords[] = $stopLat . ',' . $stopLon;

            // Add markers for start and end points
            $color = $this->getMarkerColor($index);
            $markers[] = 'color:' . $color . '|label:' . ($index + 1) . '|' . $startLat . ',' . $startLon;
            $markers[] = 'color:' . $color . '|size:small|' . $stopLat . ',' . $stopLon;

            // Add path (polyline) for the route
            $paths[] = 'color:' . $color . '|weight:3|' . $startLat . ',' . $startLon . '|' . $stopLat . ',' . $stopLon;
        }

        if (empty($allCoords)) {
            return null;
        }

        // Add markers to params
        foreach ($markers as $marker) {
            $params['markers'][] = $marker;
        }

        // Add paths to params
        foreach ($paths as $path) {
            $params['path'][] = $path;
        }

        // Auto-center and zoom to fit all points
        if (count($allCoords) > 1) {
            // Let Google auto-fit the map to include all markers and paths
            // No need to set center and zoom manually
        } else {
            // Single point - center on it
            $params['center'] = $allCoords[0];
            $params['zoom'] = 15;
        }

        // Build query string
        $queryParts = [];
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    $queryParts[] = $key . '=' . urlencode($v);
                }
            } else {
                $queryParts[] = $key . '=' . urlencode($value);
            }
        }

        return $baseUrl . '?' . implode('&', $queryParts);
    }

    /**
     * Get marker color for route index
     */
    private function getMarkerColor(int $index): string
    {
        $colors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];
        return $colors[$index % count($colors)];
    }

    /**
     * Generate map image as base64 data URL for PDF embedding
     */
    public function generateMapImageForPdf(array $rides, int $width = 600, int $height = 400): ?string
    {
        $mapData = $this->generateStaticMapWithRoutes($rides, $width, $height);

        if (!$mapData) {
            return null;
        }

        // Check if it's binary image data (from Google Maps) or SVG
        if (strpos($mapData, '<svg') === 0) {
            // It's SVG data
            return 'data:image/svg+xml;base64,' . base64_encode($mapData);
        } else {
            // It's binary PNG data from Google Maps
            return 'data:image/png;base64,' . base64_encode($mapData);
        }
    }
}
