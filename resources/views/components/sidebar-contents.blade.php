@php use Illuminate\Support\Facades\Gate; @endphp

<div class="sidebar-menu">
    <div class="flex h-16 shrink-0 items-center">
        <a href="{{ route('dashboard') }}" class="text-white rounded-lg text-xl">
            <img src="{{ asset('images/logo/logo-car.png') }}" class="h-8" alt="">
        </a>
    </div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            @if(Gate::allows('cleaning') || Gate::allows('admin'))
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}" @class(['group sidebar-item', 'active' => Route::is('dashboard')])>
                                <i class="fa-regular fa-rectangle-list fa-lg group-hover:text-white"></i>
                                Přehled
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customers.index') }}" @class(['group sidebar-item', 'active' => Route::is('customers.index')])>
                                <i class="fa-solid fa-folder-open fa-lg group-hover:text-white"></i>
                                Zákazníci
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.feedback') }}" @class(['group sidebar-item', 'active' => Route::is('admin.feedback')])>
                                <i class="fa-solid fa-star fa-lg group-hover:text-white"></i>
                                Recenze
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('invoices.index') }}" @class(['group sidebar-item', 'active' => Route::is('invoices.index')])>
                                <i class="fa-regular fa-file-lines fa-lg group-hover:text-white"></i>
                                Faktury
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('vouchers.index') }}" @class(['group sidebar-item', 'active' => Route::is('vouchers.index')])>
                                <i class="fa-solid fa-gift fa-lg group-hover:text-white"></i>
                                Vouchery
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            @if(Illuminate\Support\Facades\Gate::allows('admin'))
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.development') }}" @class(['group sidebar-item', 'active' => Route::is('admin.development')])>
                                <i class="fa-solid fa-bug fa-lg group-hover:text-white"></i>
                                Vývoj
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" @class(['group sidebar-item', 'active' => Route::is('admin.users.index')])>
                                <i class="fa-solid fa-user-gear fa-lg group-hover:text-white"></i>
                                Uživatelé
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <li>
                        <a href="{{ route('vin.index') }}"
                           class="group flex items-center gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-primary-200 hover:bg-primary-700 hover:text-white dark:text-primary-100 dark:hover:bg-primary-950/25">
                            <i class="fa-solid fa-qrcode fa-lg text-primary-200 group-hover:text-white dark:text-primary-100"></i>
                            VIN Check
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vehicles.index') }}"
                           class="group flex items-center gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-primary-200 hover:bg-primary-700 hover:text-white dark:text-primary-100 dark:hover:bg-primary-950/25">
                            <i class="fa-regular fa-truck fa-lg text-primary-200 group-hover:text-white dark:text-primary-100"></i>
                            Vozový park
                        </a>
                    </li>
                </ul>
            </li>
            <li class="mt-auto">
                @if($isDev)
                    @php $tag = exec("git describe --tags ".exec("git rev-list --tags --max-count=1")) @endphp
                    <span
                        class="text-xs text-gray-300 p-0 m-0 ml-1">v{{ $tag }} build {{ date('F j', exec('git log -1 --format=%at '.$tag)) }}</span>
                @endif
                <a href="{{ route('logout') }}"
                   class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-primary-200 hover:bg-primary-700 hover:text-white dark:text-primary-100 dark:hover:bg-primary-950/25">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                         aria-hidden="true"
                         class="size-6 shrink-0 text-primary-200 group-hover:text-white dark:text-primary-100">
                        <path
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"
                            stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                    Odhlásit se
                </a>
            </li>
        </ul>
    </nav>
</div>
