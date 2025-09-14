<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Záznam o provozu vozidla</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .header .date {
            font-size: 14px;
            font-weight: bold;
            color: #666;
        }

        .section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
        }

        .section h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 10px 0;
        }

        .grid-3 {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .grid-3 > div {
            display: table-cell;
            padding-right: 15px;
            vertical-align: top;
        }

        .grid-4 {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        .grid-4 > div {
            display: table-cell;
            text-align: center;
            padding: 0 10px;
        }

        .label {
            font-size: 9px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .value {
            font-size: 12px;
            color: #333;
        }

        .summary-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 8px;
        }

        .table th {
            background-color: #343a40;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #dee2e6;
        }

        .table td {
            padding: 4px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .footer {
            position: fixed;
            bottom: 10mm;
            left: 15mm;
            right: 15mm;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Záznam o provozu vozidla</h1>
        <div class="date">{{ DateTime::createFromFormat('Y-m-d', $date)->format('d.m.Y') }}</div>
    </div>

    <!-- Vehicle Information -->
    <div class="section">
        <h2>Informace o vozidle</h2>
        <div class="grid-3">
            <div>
                <div class="label">SPZ</div>
                <div class="value">{{ $vehicle->spz ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="label">Výrobce</div>
                <div class="value">{{ $vehicle->manufacturer ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="label">Model</div>
                <div class="value">{{ $vehicle->model ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="section">
        <h2>Souhrn za den</h2>
        <div class="grid-4">
            <div>
                <div class="label">Celkem jízd</div>
                <div class="summary-value">{{ count($rides) }}</div>
            </div>
            <div>
                <div class="label">Celková vzdálenost</div>
                <div class="summary-value">{{ number_format(collect($rides)->sum('DRIVEDIST'), 1) }} km</div>
            </div>
            <div>
                <div class="label">Prům. rychlost</div>
                <div class="summary-value">{{ number_format(collect($rides)->avg('VEAVG'), 1) }} km/h</div>
            </div>
            <div>
                <div class="label">Max. rychlost</div>
                <div class="summary-value">{{ collect($rides)->max('VEMAX') }} km/h</div>
            </div>
        </div>
    </div>

    <!-- Rides Table -->
    @if(count($rides) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Začátek jízdy</th>
                    <th>Konec jízdy</th>
                    <th>Doba trvání</th>
                    <th>Vzdálenost</th>
                    <th>Začátek - město</th>
                    <th>Konec - město</th>
                    <th>Max. rychlost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rides as $ride)
                    <tr>
                        <td>{{ $ride['STARTTIME'] }}</td>
                        <td>{{ $ride['STOPTIME'] }}</td>
                        <td>{{ \Carbon\CarbonInterval::seconds($ride['TIMEDIFF'])->cascade()->forHumans() }}</td>
                        <td>{{ $ride['DRIVEDIST'] }} km</td>
                        <td>{{ $ride['STARTOBEC'] }}</td>
                        <td>{{ $ride['STOPOBEC'] }}</td>
                        <td>{{ $ride['VEMAX'] }} km/h</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Google Maps Section -->
    @if(count($rides) > 0)
        <div class="section">
            <h2>Mapa tras</h2>
            @if($mapImage)
                <div style="text-align: center; margin: 15px 0;">
                    <img src="{{ $mapImage }}" alt="Google Maps - Mapa tras" style="max-width: 100%; height: auto; border: 1px solid #dee2e6; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                </div>
                <div style="font-size: 8px; color: #666; text-align: center; margin-top: 10px;">
                    <strong>Google Maps:</strong> Interaktivní mapa zachycená s polylines trasami a číslovanými body startu/konce každé jízdy
                </div>
            @else
                <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; padding: 15px; text-align: center;">
                    <div style="font-size: 10px; color: #856404; margin-bottom: 10px;">
                        <strong>⚠️ Mapa nebyla zachycena</strong>
                    </div>
                    <div style="font-size: 8px; color: #856404; margin-bottom: 10px;">
                        Pro zobrazení Google Maps v PDF exportu:
                    </div>
                    <div style="font-size: 8px; color: #856404; text-align: left; margin: 0 auto; max-width: 400px;">
                        1. Přejděte na stránku "Mapa tras" pro tento datum<br>
                        2. Klikněte na tlačítko "Zachytit mapu"<br>
                        3. Poté znovu exportujte PDF
                    </div>
                </div>

                <!-- Fallback: GPS coordinates table -->
                <div style="margin-top: 15px;">
                    <h3 style="font-size: 10px; margin-bottom: 10px;">GPS souřadnice tras:</h3>
                    <div style="display: table; width: 100%; table-layout: fixed;">
                        @foreach($rides as $index => $ride)
                            @if($index % 2 == 0)
                                <div style="display: table-row;">
                            @endif
                            <div style="display: table-cell; background-color: white; padding: 8px; border: 1px solid #dee2e6; margin: 2px; vertical-align: top;">
                                <div style="font-weight: bold; margin-bottom: 3px; font-size: 9px;">Jízda {{ $index + 1 }}</div>
                                <div style="font-size: 8px;"><strong>Start:</strong> {{ $ride['STARTGPSLA'] ?? 'N/A' }}, {{ $ride['STARTGPSLO'] ?? 'N/A' }}</div>
                                <div style="font-size: 8px;"><strong>Cíl:</strong> {{ $ride['STOPGPSLA'] ?? 'N/A' }}, {{ $ride['STOPGPSLO'] ?? 'N/A' }}</div>
                                <div style="font-size: 8px;"><strong>Vzdálenost:</strong> {{ $ride['DRIVEDIST'] }} km</div>
                            </div>
                            @if($index % 2 == 1 || $loop->last)
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        Vygenerováno: {{ now()->format('d.m.Y H:i:s') }} | Systém evidence vozidel
    </div>
</body>
</html>
