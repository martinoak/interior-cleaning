@extends('admin/layout')

@section('content')
    <div>
        <div class="px-4 sm:px-0 flex justify-between">
            <h3 class="heading-title">Detail vozidla</h3>
            <div class="space-y-4 flex gap-6">
                <a href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}" class="black">
                    <i class="fa-solid fa-file-pen mr-2"></i> Upravit vozidlo
                </a>

                <form action="{{ route('vehicles.destroy', ['vehicle' => $vehicle->id]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="red" onclick="return confirm('Opravdu smazat vozidlo? Tato akce je nevratná.')">
                        <i class="fa-solid fa-trash mr-2"></i>
                        Smazat vozidlo
                    </button>
                </form>
            </div>
        </div>
        <div class="mt-6 border-t border-gray-100 dark:border-white/10">
            <dl class="divide-y divide-gray-100 dark:divide-white/10">
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Výrobce</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        {{ $vehicle->manufacturer }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Model</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        {{ $vehicle->model }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Rok výroby</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        {{ $vehicle->productionYear }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">VIN</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200 flex items-center font-bold">
                        {{ $vehicle->vin }}
                        <button type="button" class="ml-2 py-4! primary" onclick="navigator.clipboard.writeText('{{ $vehicle->vin }}')">
                            <i class="fa-regular fa-paste fa-lg"></i>
                        </button>
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">SPZ</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        <x-license-plate :spz="$vehicle->spz" size="md" />
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Letní pneu</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        @if($vehicle->spneu)
                            {{ $vehicle->spneu }}
                        @else
                            <em class="text-gray-400">--- Nevyplněno ---</em>
                        @endif
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Zimní pneu</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        @if($vehicle->wpneu)
                            {{ $vehicle->wpneu }}
                        @else
                            <em class="text-gray-400">--- Nevyplněno ---</em>
                        @endif
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">
                        <img src="{{ asset('images/oni.png') }}" alt="ONI system ID" class="h-6 inline-block">
                    </dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        @if($vehicle->oni_id)
                            <div class="flex justify-between items-center gap-24">
                                <strong>{{ $vehicle->oni_id }}</strong>
                                <a href="#" class="red font-bold">Získat data z ONI</a>
                            </div>
                        @else
                            <em class="text-gray-400">--- Nevyplněno ---</em>
                        @endif
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Přílohy</dt>
                    <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0 dark:text-white">
                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-white/5 dark:border-white/10">
                            @if($vehicle->vtp)
                                <li class="flex items-center justify-between py-4 pr-5 pl-4 text-sm/6">
                                    <div class="flex w-0 flex-1 items-center">
                                        <i class="fa-solid fa-paperclip fa-lg text-gray-500 dark:text-gray-300"></i>
                                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                            <span class="truncate font-medium text-gray-900 dark:text-white">VTP</span>
                                        </div>
                                    </div>
                                    <div class="ml-4 shrink-0">
                                        <a href="{{ $vehicle->vtp }}"
                                           class="font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300"
                                           target="_blank"
                                        >
                                            Zobrazit
                                        </a>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-gray-100">Servisní kniha</dt>
                    <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0 dark:text-white">
                        <a href="{{ route('service-book.create', ['vehicle' => $vehicle->id]) }}" class="black mb-4">
                            <i class="fa-solid fa-plus mr-2"></i> Přidat záznam
                        </a>
                        <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200 dark:divide-white/5 dark:border-white/10">
                            @foreach($vehicle->serviceLog()->orderBy('service_date', 'desc')->get() as $log)
                                <li>
                                    <div class="flex items-center justify-between py-4 pr-5 pl-4 text-sm/6">
                                        <div class="flex items-center">
                                            <i class="fa-solid fa-wrench fa-lg text-gray-500 dark:text-gray-300"></i>
                                            <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                <span class="truncate font-medium text-gray-900 dark:text-white">{{ $log->title }}</span>
                                            </div>
                                        </div>
                                        <div class="w-1/3 grid grid-cols-2 gap-4">
                                            <div class="text-right">
                                                <span class="text-gray-500 dark:text-gray-300">Cena</span>
                                                <span class="font-bold text-gray-700 dark:text-gray-200">{{ number_format($log->price, 0, ',', ' ') }} Kč</span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-gray-500 dark:text-gray-300">Doba</span>
                                                <span class="font-bold text-gray-700 dark:text-gray-200">{{ $log->hours }} h</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 pb-4 pt-2 sm:grid sm:grid-cols-3 sm:gap-4">
                                        @foreach($log->attachments()->get() as $att)
                                            <a href="{{ route('attachment', ['id' => $att->id]) }}" class="ml-4 inline-block text-sm text-gray-900 dark:text-white">
                                                <i class="fa-solid fa-paperclip mr-2"></i> {{ $att->title }}
                                            </a>
                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="font-medium text-gray-900 dark:text-gray-100">Statistika</dt>
                    <dd class="mt-1 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                        Připravuje se...
                    </dd>
                </div>
            </dl>
        </div>
    </div>
@endsection
