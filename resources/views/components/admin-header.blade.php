<nav class="bg-gray-50 dark:bg-gray-800 shadow-xl sm:ml-64 hidden sm:block">
    <div class="flex items-center justify-end mx-auto p-4">
        <div class="ml-4 items-center hidden md:flex md:w-auto text-black dark:text-white" id="navbar-default">
            <img class="w-8 h-6 mx-2 rounded-full object-fit block dark:hidden" src="{{ asset('images/logo/logo-car2.png') }}" alt=""/>
            <img class="w-8 h-6 mx-2 rounded-full object-fit hidden dark:block" src="{{ asset('images/logo/logo-car.png') }}" alt=""/>
            <span class="font-bold">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
            <button id="moonButton" class="w-8 h-8 bg-gray-700 rounded-xs mx-4 block dark:hidden"><i class="fa-solid fa-moon text-white"></i></button>
            <button id="sunButton" class="w-8 h-8 bg-[#3056d3] rounded-xs mx-4 hidden dark:block"><i class="fa-solid fa-sun text-white"></i></button>
        </div>
    </div>
</nav>
