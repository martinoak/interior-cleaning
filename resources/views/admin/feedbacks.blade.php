@extends('admin/layout')

@section('content')
    <div class="flex justify-between">
        <h1 class="heading-title">Recenze</h1>
        <a href="{{ route('admin.feedbacks.refresh') }}" class="black"><i class="fa-brands fa-google fa-lg mr-1"></i> Import</a>
    </div>

    <div class="py-4 sm:py-3">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <dl class="grid gap-x-8 gap-y-16 text-center grid-cols-2">
                <div class="feedback-wrapper">
                    <dt class="feedback-title">Celkem recenzí</dt>
                    <dd class="feedback-value">{{ \App\Models\Feedback::count() }}</dd>
                </div>
                <div class="feedback-wrapper">
                    <dt class="feedback-title">Průměrné hodnocení</dt>
                    <dd class="feedback-value">{{ number_format(\App\Models\Feedback::avg('rating'), 2) }}</dd>
                </div>
            </dl>
        </div>
    </div>
    <hr class="w-46 lg:w-96 h-1 mx-auto bg-gray-300 border-0 rounded-xs dark:bg-gray-50 my-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
        @foreach($feedbacks as $feedback)
            <div class="cell {if !$feedback->message}flex justify-between{/if}">
                <div class="cell-content justify-between">
                    <h2 class="cell-title">
                        @if($feedback->fromGoogle)
                            <span class="px-2 bg-black rounded-xs icon"><i class="fa-brands fa-google text-white fa-xs"></i></span>
                        @endif
                        {{ $feedback->name }}
                    </h2>
                    <p class="sm:hidden cell-text space-x-2 text-lg">
                        {{ $feedback->rating }} <i class="text-yellow-500 fa-solid fa-star"></i>
                    </p>
                    <p class="hidden sm:block cell-text space-x-2 text-lg">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $feedback->rating)
                                <i class="text-yellow-500 fa-solid fa-star"></i>
                            @else
                                <i class="fa-regular fa-star"></i>
                            @endif
                        @endfor
                    </p>
                </div>
                <p class="cell-note">{{ $feedback->message }}</p>
            </div>
        @endforeach
    </div>
@endsection
