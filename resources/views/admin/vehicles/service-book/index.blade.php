@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading">
            <h1 class="heading-title">Servisní kniha</h1>

            <aside class="flex gap-4">
                <a href="{{ route('service-book.create', ['vehicle' => $vehicle->id]) }}" class="button-black"><i class="fa-solid fa-plus fa-lg icon"></i> Přidat záznam</a>
            </aside>
        </div>

        <span class="text-gray-500 dark:text-gray-300 mb-6">
            <i class="{{ \App\Enums\VehicleType::getIcon($vehicle->type) }} mr-2" style="color: {!! $vehicle->color !!}"></i>
            {{ $vehicle->manufacturer }} {{ $vehicle->model }} ({{ $vehicle->spz }})
        </span>

        <ol class="relative border-s border-gray-200 dark:border-gray-700">
            @foreach($vehicle->serviceLog()->orderBy('service_date', 'desc')->get() as $log)
                <li class="mb-10 ms-4">
                    <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                    <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ Carbon\Carbon::parse($log->service_date)->format('j.n.Y') }}</time>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $log->title }}</h3>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($log->price, 0, ',', ' ') }} Kč</h3>
                    </div>

                    <div class="flex justify-between">
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 size-max">{{ $log->note }}</p>
                        <p class="w-1/2 text-right ml-4">{{ $log->hours }} h</p>
                    </div>

                    <div class="@if($log->attachments()?->get())justify-between @else justify-end @endif flex items-center">
                        @if($log->attachments()?->get())
                            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                                <i class="fa-solid fa-paperclip mr-2"></i> Přílohy
                            </a>
                        @endif
                        <div class="flex space-x-2">
                            {{--<a href="{route('service-book.edit', [vehicle => $vehicle->id, id => $log->id])}" class="button-black" type="button">
                                <i class="fa-solid fa-pen fa-lg"></i>
                            </a>--}}
                            <form method="post" action="{{ route('service-book.destroy', ['vehicle' => $vehicle->id, 'id' => $log->id]) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
                                <button class="button-red" type="submit" onclick="return confirm('Opravdu smazat záznam?')">
                                    <i class="fa-solid fa-trash fa-lg"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
@endsection
