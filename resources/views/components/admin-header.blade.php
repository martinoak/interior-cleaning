<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-xs sm:gap-x-6 sm:px-6 lg:px-8 dark:border-white/10 dark:bg-zinc-800 dark:shadow-none">
    <button type="button" command="show-modal" commandfor="sidebar" class="-m-2.5 p-2.5 text-gray-700 hover:text-gray-900 lg:hidden dark:text-gray-400 dark:hover:text-white">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>

    <div class="flex w-full justify-end gap-x-4 self-stretch lg:gap-x-6">
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            <!-- Separator -->
            <div aria-hidden="true" class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10 dark:lg:bg-gray-100/10"></div>

            <!-- Profile dropdown -->
            <el-dropdown class="relative flex items-center">
                <button class="relative flex items-center">
                    <span class="absolute -inset-1.5"></span>
                    <img class="w-8 h-6 rounded-full object-fit block dark:hidden" src="{{ asset('images/logo/logo-car2.png') }}" alt=""/>
                    <img class="w-8 h-6 rounded-full object-fit hidden dark:block" src="{{ asset('images/logo/logo-car.png') }}" alt=""/>
                    <span class="hidden lg:flex lg:items-center">
                        <span aria-hidden="true" class="mx-4 text-sm/6 font-semibold text-gray-900 dark:text-white">
                            {{ \Illuminate\Support\Facades\Auth::user()?->name }}
                        </span>
                    </span>

                    <button id="moonButton" class="w-8 h-8 bg-gray-700 rounded-sm block dark:hidden"><i class="fa-solid fa-moon text-white"></i></button>
                    <button id="sunButton" class="w-8 h-8 bg-primary rounded-sm hidden dark:block"><i class="fa-solid fa-sun text-white"></i></button>
                </button>
            </el-dropdown>
        </div>
    </div>
</div>
