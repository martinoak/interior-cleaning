@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-center w-full sm:hidden">
            <h1 class="heading-title">NEOPTIMALIZOVÁNO</h1>
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div class="cell-simple">
                PHP {{ phpversion() }}
            </div>
            <div class="cell-simple">
                Laravel v{{ \Illuminate\Foundation\Application::VERSION }}
            </div>
            <div class="cell-simple">
                <a class="text-2xl text-gray-400 dark:text-gray-500" href="https://github.com/martinoak/interior-cleaning" target="_blank">
                    <i class="fa-brands fa-github fa-xl hover:text-[#3056d3]"></i>
                </a>
            </div>
        </div>
        <div class="flex">
            <div class="grid grid-cols-1 mb-4 flex" style="width: calc(80% + 20px)">
                <div class="cell">
                    <div class="cell-content">
                        <p class="cell-title mb-2">
                            CRON log
                        </p>
                    </div>
                    @php $content = implode("\n", array_slice(preg_split("/\r\n|\n|\r/", file_get_contents(storage_path('logs/cron.log'))), -15)) @endphp
                    <pre class="w-full">{!! $content !!}</pre>
                </div>
            </div>
            <div class="grid grid-cols-1 mb-4 ml-4 flex w-1/5">
                <div class="cell-simple h-full">
                    <div class="flex flex-col space-y-8 text-center text-gray-400 dark:text-gray-500">
                        <p class="cell-title">Error log</p>
                        <a class="text-sm hover:text-[#f55247]" href="{{ route('admin.errorlog', ['type' => 'laravel']) }}"><i class="fa-brands fa-laravel fa-xl mr-2"></i>Laravel</a>
                        <a class="text-sm hover:text-white" href="{{ route('admin.errorlog', ['type' => 'cron']) }}"><i class="fa-regular fa-hourglass fa-xl mr-2"></i>Cron</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="inline-flex items-center justify-center w-full">
        <hr class="w-96 h-1 my-8 bg-gray-300 border-0">
        <span class="absolute px-3 font-black text-gray-900 text-xl -translate-x-1/2 bg-gray-50 dark:bg-gray-900 left-1/2 dark:text-white">Schéma</span>
    </div>
    <div class="p-4 sm:ml-64">
        <div class="grid grid-cols-6 gap-4 mb-4">
            <div class="cell-simple h-12" style="background-color: rgb(48 86 211)">#3056d3</div>
            <div class="cell-simple h-12" style="background-color: rgb(79 70 229)">#4f46e5</div>
            <div class="cell-simple h-12" style="background-color: rgb(21 128 61)">#15803d</div>
            <div class="cell-simple h-12" style="background-color: rgb(255 145 25)">#ff9119</div>
            <div class="cell-simple h-12" style="background-color: rgb(185 28 28)">#b91c1c</div>
            <div class="cell-simple h-12" style="background-color: rgb(0 0 0)">#000000</div>
        </div>
    </div>
@endsection
