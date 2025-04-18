@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading">
            <div>
                <h1 class="heading-title">VIN Check</h1>
                <button data-modal-target="new-vin" data-modal-toggle="new-vin" class="button-green" type="button">
                    <i class="fa-regular fa-plus fa-lg text-white mr-1"></i> VIN
                </button>
            </div>
        </div>
        <div id="new-vin" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <div class="relative bg-white shadow-xs dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Nové VIN
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Zavřít</span>
                        </button>
                    </div>
                    <div class="p-4 md:p-5 space-y-4">
                        <form class="mx-auto" method="post" action="{{ route('vin.store') }}">
                            @csrf
                            <div class="mb-5">
                                <label for="vin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VIN *</label>
                                <input type="text" id="vin" name="vin" value="{{ old('vin') }}" class="form-input" required>
                            </div>
                            <div class="mb-5">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vlastník auta *</label>
                                <input type="text" id="name" name="name" class="form-input" required>
                            </div>
                            <div class="form-buttons">
                                <button type="submit" class="form-submit">Odeslat</button>
                                <button type="reset" class="form-reset">Vymazat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="accordion" data-accordion="collapse">
            @foreach($cars as $car)
                <div id="accordion-collapse-heading-{{ $car->vin }}" class="cursor-pointer">
                    <div class="flex items-center justify-between w-full p-5 font-medium text-gray-500 border {if !$iterator->last}border-b-0{/if} border-gray-200 {if $iterator->first}rounded-t-xl{/if} focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-{{ $car->vin }}" aria-expanded="false">
                        <span><i class="me-2 fa-solid fa-car"></i> {{ $car->name }} {{ $car->model }}</span>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('vin.edit', ['vin' => $car->vin]) }}" type="button" class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            <a href="{{ route('vin.destroy', ['vin' => $car->vin]) }}" type="button" class="cursor-pointer text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <svg data-accordion-icon class="ml-3 w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div id="accordion-collapse-body-{{ $car->vin }}" class="hidden" aria-labelledby="accordion-collapse-heading-{{ $car->vin }}">
                    <div class="relative overflow-x-auto shadow-md">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <tbody>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="w-1/6 sm:w-1/5 px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    VIN
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->vin }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Majitel
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->name }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Výrobce
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->manufacturer }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Model
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->model }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Motor
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->engine }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Rok výroby
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->year }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Poznámka
                                </th>
                                <td class="px-6 py-4">
                                    {{ $car->note }}
                                </td>
                            </tr>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                    Zkontrolováno
                                </th>
                                <td class="px-6 py-4 font-bold">
                                    @if($car->vin)<span class="text-green-600">ANO</span>@else<span class="text-red-600">NE</span>@endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
