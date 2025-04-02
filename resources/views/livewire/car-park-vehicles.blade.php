<div class="p-4 sm:ml-64">
    <div class="heading">
        <object class="inline-flex rounded-md shadow-xs">
            @foreach(\App\Enums\VehicleType::cases() as $type)
                <button type="button"
                        name="types[]"
                        value="{{ $type->value }}"
                        wire:click="refreshTypes('{{ $type->value }}')"
                        class="px-4 py-2 text-sm font-medium text-gray-900 @if(! $types->contains($type->value))bg-blue-800 @else bg-transparent @endif @if($loop->first || $loop->last)border @else border-b border-t @endif border-gray-900 @if($loop->first)rounded-s-lg @elseif($loop->last)rounded-e-lg @endif hover:bg-gray-900 hover:text-white focus:z-10 dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700"
                >
                    <i class="{{ \App\Enums\VehicleType::getIcon($type->value) }} fa-lg"></i>
                </button>
            @endforeach
        </object>

        <aside>
            <a href="{{ route('vehicles.create') }}" class="button-black"><i class="fa-solid fa-plus fa-lg icon"></i> Přidat vozidlo</a>
        </aside>
    </div>

    @foreach($vehicles as $vehicle)
        <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="block w-full lg:w-1/2 p-3 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                <i class="{{ \App\Enums\VehicleType::getIcon($vehicle->type) }} mr-2" style="color: {!! $vehicle->color !!}"></i>
                {{ $vehicle->manufacturer }} {{ $vehicle->model }} <span class="ml-2 text-gray-400">{{ $vehicle->spz }}</span>
            </h5>
            <p class="font-normal text-gray-700 dark:text-gray-400">STK do: {{ $vehicle->stk?->format('j.n.Y') }}</p>
        </a>
    @endforeach
</div>
