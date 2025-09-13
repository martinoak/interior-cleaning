@extends('admin/layout')

@section('content')
    <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="cell-simple">
            PHP {{ phpversion() }}
        </div>
        <div class="cell-simple">
            Laravel v{{ \Illuminate\Foundation\Application::VERSION }}
        </div>
        <div class="cell-simple">
            <a class="text-2xl text-gray-400 dark:text-gray-500" href="https://github.com/martinoak/interior-cleaning" target="_blank">
                <i class="fa-brands fa-github fa-xl hover:text-primary"></i>
            </a>
        </div>
    </div>
    <div class="flex">
        <div class="grid grid-cols-1 mb-4" style="width: calc(80% + 20px)">
            <div class="cell">
                <div class="cell-content">
                    <p class="cell-title mb-2">
                        CRON log
                    </p>
                </div>
                @php $content = implode("\n", array_slice(preg_split("/\r\n|\n|\r/", file_get_contents(storage_path('logs/cron.log'))), -15)) @endphp
                <pre class="w-full dark:text-gray-300">{!! $content !!}</pre>
            </div>
        </div>
        <div class="grid grid-cols-1 mb-4 ml-4 w-1/5">
            <div class="cell-simple h-full!">
                <div class="flex flex-col space-y-8 text-center text-gray-400 dark:text-gray-500">
                    <p class="cell-title">Error log</p>
                    <a class="text-sm hover:text-[#f55247]" href="{{ route('admin.errorlog', ['type' => 'laravel']) }}"><i class="fa-brands fa-laravel fa-xl mr-2"></i>Laravel</a>
                    <a class="text-sm hover:text-white" href="{{ route('admin.errorlog', ['type' => 'cron']) }}"><i class="fa-regular fa-hourglass fa-xl mr-2"></i>Cron</a>
                </div>
            </div>
        </div>
    </div>
@endsection
