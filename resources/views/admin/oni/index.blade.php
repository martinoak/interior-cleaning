@extends('admin/layout')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="heading-title">Seznam vozů z ONI systému</h1>
                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Přehled vozidel evidovaných v portálu ONI system a jejich specifikace</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ url()->current() }}" class="primary">Obnovit stránku</a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">Název</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">ID vozidla</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white">Aktivní</th>
                            <th scope="col" class="py-3.5 pr-4 text-right pl-3 sm:pr-0 text-gray-900 dark:text-white">
                                Akce
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                            @foreach($vehicles as $vehicle)
                                @continue($vehicle['is_active'] === 'F')
                                <tr>
                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">{{ $vehicle['name'] }}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $vehicle['id'] }}</td>
                                    <td class="px-3 py-4 text-sm text-center whitespace-nowrap text-gray-500 dark:text-gray-400">
                                        @if($vehicle['is_active'] === 'T')
                                            <span class="badge-green">ANO</span>
                                        @else
                                            <span class="badge-red">NE</span>
                                        @endif
                                    </td>
                                    <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                        <a href="{{ route('oni.show', ['oni' => $vehicle['id']]) }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Detail vozidla
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
