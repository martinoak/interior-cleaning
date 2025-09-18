<div>
    <div class="flex justify-between mb-4" style="width: unset">
        <div class="inline-flex rounded-lg shadow-2xs">
            @foreach(\App\Enums\VehicleType::cases() as $type)
                <label class="px-4 py-2 text-sm font-medium cursor-pointer border @if($selectedType === $type->value) text-white bg-blue-800 @else text-gray-800 bg-transparent @endif @if($loop->last) rounded-e-lg @elseif($loop->first) rounded-s-lg border-b border-t @endif border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700">
                    <input type="radio"
                           wire:model.live="selectedType"
                           value="{{ $type->value }}"
                           class="sr-only">
                    <i class="{{ \App\Enums\VehicleType::getIcon($type->value) }} fa-lg"></i>
                </label>
            @endforeach
        </div>

        <aside class="flex space-x-4">
            <a href="{{ route('oni.index') }}" class="black">
                <img src="{{ asset('images/oni.png') }}" class="h-4 lg:mr-2">
                <span class="hidden lg:block">Získat data z ONI systému</span>
            </a>

            <a href="{{ route('vehicles.create') }}" class="black">
                <i class="fa-solid fa-plus fa-lg icon mr-0! lg:mr-2"></i>
                <span class="hidden lg:block">Přidat vozidlo</span>
            </a>
        </aside>
    </div>

    <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
        @foreach($vehicles as $vehicle)
            <li class="overflow-hidden rounded-xl outline outline-gray-200 dark:-outline-offset-1 dark:outline-white/10">
                <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 dark:border-white/10 dark:bg-[#212121]">
                    <i class="{{ \App\Enums\VehicleType::getIcon($vehicle->type) }} mr-2 text-shadow-lg fa-xl" style="color: {!! $vehicle->color !!}"></i>
                    <div class="text-xl font-medium text-gray-900 dark:text-white">
                        {{ $vehicle->manufacturer }} {{ $vehicle->model }}
                    </div>
                    <el-dropdown class="relative ml-auto">
                        <button class="relative block text-gray-400 hover:text-gray-500 dark:text-gray-400 dark:hover:text-white">
                            <span class="absolute -inset-2.5"></span>
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <el-menu anchor="bottom end" popover class="w-32 origin-top-right rounded-md bg-white py-2 shadow-lg outline-1 outline-gray-900/5 transition transition-discrete [--anchor-gap:--spacing(0.5)] data-closed:scale-95 data-closed:transform data-closed:opacity-0 data-enter:duration-100 data-enter:ease-out data-leave:duration-75 data-leave:ease-in dark:bg-[#212121] dark:shadow-none dark:-outline-offset-1 dark:outline-white/10">
                            <a href="{{ route('vehicles.show', ['vehicle' => $vehicle->id]) }}" class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden dark:text-white dark:focus:bg-white/5">Zobrazit</a>
                            <a href="{{ route('vehicles.edit', ['vehicle' => $vehicle->id]) }}" class="block px-3 py-1 text-sm/6 text-gray-900 focus:bg-gray-50 focus:outline-hidden dark:text-white dark:focus:bg-white/5">Upravit</a>
                        </el-menu>
                    </el-dropdown>
                </div>
                <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm/6 dark:divide-white/10">
                    <div class="flex justify-between gap-x-4 py-3">
                        <dt class="text-gray-500 dark:text-gray-300">SPZ</dt>
                        <dd class="text-gray-700 dark:text-gray-200">
                            <x-license-plate :spz="$vehicle->spz" size="sm" />
                        </dd>
                    </div>
                    @if($vehicle->stk)
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500 dark:text-gray-300">STK</dt>
                            <dd class="text-gray-700 dark:text-gray-200">
                                <x-badge :red="$vehicle->stk->diffInDays(now()) > -14" :orange="$vehicle->stk->diffInDays(now()) > -60" :text="$vehicle->stk->format('j.n.Y')" />
                            </dd>
                        </div>
                    @endif
                    @if($vehicle->type === \App\Enums\VehicleType::CAR->value && $vehicle->oilChange)
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500 dark:text-gray-300">Výměna oleje</dt>
                            <dd class="text-gray-700 dark:text-gray-200">
                                <x-badge :red="$vehicle->oilChange->diffInDays(now()) > -14" :orange="$vehicle->oilChange->diffInDays(now()) > -60" :text="$vehicle->oilChange->format('j.n.Y')" />
                            </dd>
                        </div>
                    @endif
                    @if($vehicle->type === \App\Enums\VehicleType::TRUCK->value && $vehicle->tachograph)
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500 dark:text-gray-300">Tachograf</dt>
                            <dd class="text-gray-700 dark:text-gray-200">
                                <x-badge :red="$vehicle->tachograph->diffInDays(now()) > -14" :orange="$vehicle->tachograph->diffInDays(now()) > -60" :text="$vehicle->tachograph->format('j.n.Y')" />
                            </dd>
                        </div>
                    @endif
                    @if($vehicle->type === \App\Enums\VehicleType::WORK->value && $vehicle->insurance)
                        <div class="flex justify-between gap-x-4 py-3">
                            <dt class="text-gray-500 dark:text-gray-300">Povinné ručení</dt>
                            <dd class="text-gray-700 dark:text-gray-200">
                                <x-badge :red="$vehicle->insurance->diffInDays(now()) > -14" :orange="$vehicle->insurance->diffInDays(now()) > -60" :text="$vehicle->insurance->format('j.n.Y')" />
                            </dd>
                        </div>
                    @endif
                </dl>
            </li>
        @endforeach
    </ul>
</div>
