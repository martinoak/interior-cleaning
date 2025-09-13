@extends('admin/layout')

@section('content')
    <div class="flex justify-between">
        <h1 class="heading-title">VIN Check</h1>
        <a href="{{ route('vin.create') }}" class="primary">
            <i class="fa-solid fa-plus fa-lg text-white mr-1"></i> Přidat VIN
        </a>
    </div>

    <dl class="mt-10 divide-y divide-gray-900/10 dark:divide-white/10">
        @foreach($cars as $car)
            <div class="py-6 first:pt-0 last:pb-0">
                <dt>
                    <button type="button"
                            command="--toggle"
                            commandfor="car-{{ $loop->index }}"
                            class="flex w-full items-start justify-between text-left text-gray-900 dark:text-white"
                    >
                        <span class="text-base/7 font-semibold">
                            {{ $car->name }} {{ $car->model }}
                        </span>
                        <span class="ml-6 flex h-7 items-center">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 in-aria-expanded:hidden">
                                <path d="M12 6v12m6-6H6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6 not-in-aria-expanded:hidden">
                                <path d="M18 12H6" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                </dt>
                <el-disclosure id="car-{{ $loop->index }}" hidden class="contents">
                    <div>
                        <div class="mt-6 border-t border-gray-100 dark:border-white/10">
                            <dl class="divide-y divide-gray-100 dark:divide-white/10">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">VIN</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400 flex items-center font-bold">
                                        {{ $car->vin }}
                                        <button type="button" class="ml-2 py-4! primary" onclick="navigator.clipboard.writeText('{{ $car->vin }}')">
                                            <i class="fa-regular fa-paste fa-lg"></i>
                                        </button>
                                    </dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Majitel</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">{{ $car->name }}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Výrobce</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">{{ $car->manufacturer }}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Model</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">{{ $car->model }}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Motor</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">{{ $car->engine }}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Rok výroby</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">{{ $car->year }}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Poznámka</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">{{ $car->note }}</dd>
                                </div>

                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">VIN zkontrolován</dt>
                                    <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                        @if($car->vin)
                                            <span class="badge-green">ANO</span>
                                        @else
                                            <span class="badge-red">NE</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                </el-disclosure>
            </div>
        @endforeach
    </dl>
@endsection
