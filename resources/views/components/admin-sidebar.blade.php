<div class="flex justify-between sm:hidden mt-2 mx-3">
    <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>
    <div class="flex items-center justify-end">
        <div class="items-center flex w-auto text-black dark:text-white" id="navbar-default">
            <img class="w-8 h-6 mx-2 rounded-full object-fit block dark:hidden" src="{{ asset('images/logo/logo-car2.png') }}" alt=""/>
            <img class="w-8 h-6 mx-2 rounded-full object-fit hidden dark:block" src="{{ asset('images/logo/logo-car.png') }}" alt=""/>
            <span class="font-bold">{{ \Illuminate\Support\Facades\Auth::user()?->name }}</span>
            <button id="moonButton-mobile" class="w-8 h-8 bg-gray-700 rounded-xs ms-4 me-1 block dark:hidden"><i class="fa-solid fa-moon text-white"></i></button>
            <button id="sunButton-mobile" class="w-8 h-8 bg-[#3056d3] rounded-xs ms-4 me-1 hidden dark:block"><i class="fa-solid fa-sun text-white"></i></button>
        </div>
    </div>
</div>

<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
    <div class="h-full px-3 py-4 overflow-y-auto bg-[#3056d3]">
        <div class="h-full flex flex-col justify-between">
            <ul class="space-y-2 font-medium">
                @if(Illuminate\Support\Facades\Gate::allows('cleaning') || Illuminate\Support\Facades\Gate::allows('admin'))
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg text-xl">
                            <img src="{{ asset('images/logo/logo-car.png') }}" class="h-10" alt="">
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-regular fa-rectangle-list"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Přehled</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customers.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-solid fa-folder-open"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Zákazníci</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.feedback') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-solid fa-star"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Recenze</span>
                            <span class="inline-flex items-center justify-center py-0.5 px-2 ml-3 text-sm font-medium text-black bg-amber-300 rounded-full">{{ number_format(DB::table('feedbacks')->avg('rating'), 2) }}</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('invoices.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-regular fa-file-lines"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Faktury</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('vouchers.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-solid fa-gift"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Vouchery</span>
                        </a>
                    </li>
                    <hr class="w-48 h-1 mx-auto bg-gray-300 border-0 rounded-xs">
                    <li>
                        <a href="{{ route('customers.index') }}#archiv" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-solid fa-archive"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Archiv</span>
                        </a>
                    </li>
                @endif
                @if(Illuminate\Support\Facades\Gate::allows('admin'))
                    <li>
                        <a href="{{ route('admin.development') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-solid fa-bug"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Vývoj</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                            <i class="text-white fa-solid fa-user-gear"></i>
                            <span class="flex-1 ml-3 whitespace-nowrap">Uživatelé</span>
                        </a>
                    </li>
                @endif
                <hr class="w-48 h-1 mx-auto bg-gray-300 border-0 rounded-xs">
                <li>
                    <a href="{{ route('vin.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                        <i class="text-white fa-solid fa-barcode"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">VIN Check</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('vehicles.index') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                        <i class="text-white fa-solid fa-truck-moving"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Vozový park</span>
                    </a>
                </li>
            </ul>
            <ul class="space-y-2 font-medium">
                <li class="mt-auto">
                    @if($isDev)
                        @php $tag = exec("git describe --tags ".exec("git rev-list --tags --max-count=1")) @endphp
                        <span class="text-xs text-gray-300 p-0 m-0 ml-2">v{{ $tag }} build {{ date('F j', exec('git log -1 --format=%at '.$tag)) }}</span>
                    @endif
                    <a href="{{ route('logout') }}" class="flex items-center p-2 text-white rounded-lg hover:bg-gray-700">
                        <i class="text-white fa-solid fa-right-from-bracket"></i>
                        <span class="flex-1 ml-3 whitespace-nowrap">Odhlásit se</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.querySelector('[data-drawer-toggle="sidebar"]');

        function hideSidebar() {
            if (window.innerWidth < 640) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('transform-none');
            }
        }

        document.addEventListener('click', function (event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggleButton = toggleButton.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnToggleButton) {
                hideSidebar();
            }
        });
    });
</script>
