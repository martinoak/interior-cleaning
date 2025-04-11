<div class="p-4 sm:ml-64">
    <div class="heading">
        <object class="inline-flex rounded-lg shadow-2xs">
            @foreach(\App\Enums\VehicleType::cases() as $type)
                <button type="button"
                        name="types[]"
                        value="{{ $type->value }}"
                        wire:click="refreshTypes('{{ $type->value }}')"
                        class="px-4 py-2 text-sm font-medium @if(! $types->contains($type->value)) text-white bg-blue-800 @else text-gray-800 bg-transparent @endif @if($loop->first || $loop->last) border @else border-b border-t @endif border-gray-900 @if($loop->first) rounded-s-lg @elseif($loop->last) rounded-e-lg @endif hover:bg-gray-900 hover:text-white focus:z-10 dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700"
                >
                    <i class="{{ \App\Enums\VehicleType::getIcon($type->value) }} fa-lg"></i>
                </button>
            @endforeach
        </object>

        <aside>
            <a href="{{ route('vehicles.create') }}" class="button-black"><i class="fa-solid fa-plus fa-lg icon"></i> Přidat vozidlo</a>
        </aside>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
        @foreach($vehicles as $vehicle)
            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle]) }}" class="block w-full p-3 bg-white border border-gray-200 rounded-lg shadow-xs hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <div class="flex justify-between">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        <i class="{{ \App\Enums\VehicleType::getIcon($vehicle->type) }} mr-2 text-shadow-lg" style="color: {!! $vehicle->color !!}"></i>
                        {{ $vehicle->manufacturer }} {{ $vehicle->model }}
                    </h5>
                    <span class="ml-2 text-gray-400">{{ $vehicle->spz }}</span>
                </div>

                <div class="flex items-center">
                    @if($vehicle->stk)
                        <p class="w-1/2 font-normal text-gray-700 dark:text-gray-400">
                            <strong class="text-black dark:text-white">STK</strong>:
                            <x-badge :red="$vehicle->stk->diffInDays(now()) > -14" :orange="$vehicle->stk->diffInDays(now()) > -60" :text="$vehicle->stk->format('j.n.Y')" />
                        </p>
                    @endif
                    @if($vehicle->type === \App\Enums\VehicleType::CAR->value && $vehicle->oilChange)
                        <p class="w-1/2 font-normal text-gray-700 dark:text-gray-400">
                            <i class="fa-solid fa-oil-can text-black dark:text-white"></i>
                            <x-badge :red="$vehicle->oilChange->diffInDays(now()) > -14" :orange="$vehicle->oilChange->diffInDays(now()) > -60" :text="$vehicle->oilChange->format('j.n.Y')" />
                        </p>
                    @elseif($vehicle->type === \App\Enums\VehicleType::TRUCK->value && $vehicle->tachograph)
                        <p class="w-1/2 font-normal text-gray-700 dark:text-gray-400">
                            <i class="fa-solid fa-tachograph-digital text-black dark:text-white"></i>
                            <x-badge :red="$vehicle->tachograph->diffInDays(now()) > -14" :orange="$vehicle->tachograph->diffInDays(now()) > -60" :text="$vehicle->tachograph->format('j.n.Y')" />
                        </p>
                    @elseif($vehicle->type === \App\Enums\VehicleType::WORK->value && $vehicle->insurance)
                        <p class="w-1/2 font-normal text-gray-700 dark:text-gray-400">
                            <i class="fa-solid fa-car-burst text-black dark:text-white"></i>
                            <x-badge :red="$vehicle->insurance->diffInDays(now()) > -14" :orange="$vehicle->insurance->diffInDays(now()) > -60" :text="$vehicle->insurance->format('j.n.Y')" />
                        </p>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
