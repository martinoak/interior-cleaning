@extends('admin/layout')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center">
        <h1 class="heading-title">Seznam jízd vozidla</h1>
        <form action="{{ route('oni.show', ['oni' => $vehicle->oni_id]) }}" method="get">
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <div class="flex gap-4">
                    <input type="date" name="start_date" value="{{ request()->get('start_date') }}" class="max-w-lg">
                    <input type="date" name="end_date" value="{{ request()->get('end_date') }}" class="w-64">
                    <button type="submit" class="primary">Filtr</button>
                </div>
            </div>
        </form>
    </div>

    @if($ridesByDate->count() > 0)
        @foreach($ridesByDate as $date => $rides)
            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                    {{ $date }}
                </h2>

                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Začátek jízdy</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Konec jízdy</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Doba trvání</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Ujetá vzdálenost</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Poloha</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Max. rychlost</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                                    @foreach($rides as $ride)
                                        <tr>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $ride['STARTTIME'] }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $ride['STOPTIME'] }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\CarbonInterval::seconds($ride['TIMEDIFF'])->cascade()->forHumans() }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $ride['DRIVEDIST'] }} km
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $ride['STARTOBEC'] ?: $ride['start_city'] }} - {{ $ride['STOPOBEC'] ?: $ride['end_city'] }}
                                            </td>
                                            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $ride['VEMAX'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Summary row for this date -->
                <div class="mt-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex space-x-8 text-sm">
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Celkem jízd:</span>
                                <span class="text-gray-600 dark:text-gray-300">{{ count($rides) }}</span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Celková vzdálenost:</span>
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ number_format(collect($rides)->sum('DRIVEDIST'), 1) }} km
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Celkový čas:</span>
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ \Carbon\CarbonInterval::seconds(collect($rides)->sum('TIMEDIFF'))->cascade()->forHumans() }}
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Max. rychlost:</span>
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ collect($rides)->max('VEMAX') }} km/h
                                </span>
                            </div>
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">Prům. rychlost:</span>
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ number_format(collect($rides)->avg('VEAVG'), 1) }} km/h
                                </span>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('oni.map', ['oni' => $id, 'date' => DateTime::createFromFormat('d.m.y', $date)->format('Y-m-d')]) }}"
                               class="inline-flex items-center px-3 py-2 border border-blue-300 shadow-sm text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-50 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-900 dark:border-blue-600 dark:text-blue-200 dark:hover:bg-blue-800">
                                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
                                </svg>
                                Mapa
                            </a>
                            <a href="{{ route('oni.export', ['oni' => $id, 'date' => DateTime::createFromFormat('d.m.y', $date)->format('Y-m-d')]) }}"
                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 1H7a2 2 0 00-2 2v16a2 2 0 002 2z"></path>
                                </svg>
                                Export jízd
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">No ride history found for this vehicle.</p>
        </div>
    @endif
</div>
@endsection
