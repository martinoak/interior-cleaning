@extends('layout')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?m={{ filemtime(public_path('css/tailwind.css')) }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?m={{ filemtime(public_path('css/style.css')) }}"/>
@endsection

@section('content')
    <section class="bg-[#3056d3]">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a class="flex flex-col items-center mb-6 text-2xl">
                <img class="h-12 mb-2" src="{{ asset('images/logo/logo-car.png') }}" alt="logo">
                <h1 class="text-white font-bold">
                    Recenze
                </h1>
            </a>
            <div class="w-full bg-white rounded-lg shadow-xs dark:border md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 md:space-y-6 sm:p-8">
                    <form class="space-y-4" method="post" action="{{ route('storeFeedback') }}">
                        @csrf
                        <input type="hidden" name="hash" value="{{ $hash }}">
                        <div>
                            <label for="variant" class="block mb-2 text-sm font-medium text-gray-900">Varianta</label>
                            <input type="text" id="variant" name="variant" class="bg-gray-100 text-gray-500 sm:text-sm rounded-lg block w-full p-2.5" value="{{ $variant }}" readonly>
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Jméno a příjmení <i class="fa-solid fa-asterisk text-red-600"></i></label>
                            <input type="text" name="name" id="name" class="bg-gray-100 sm:text-sm rounded-lg block w-full p-2.5 text-black" required>
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Text recenze</label>
                            <textarea type="text" name="message" id="name" class="bg-gray-100 sm:text-sm rounded-lg block w-full p-2.5 text-black"></textarea>
                        </div>
                        <label for="rating" class="block text-sm font-medium text-gray-900">Hodnocení <i class="fa-solid fa-asterisk text-red-600"></i></label>
                        <div class="rating">
                            <label>
                                <input type="radio" name="rating" value="1" />
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="2" />
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="3" />
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="4" />
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="5" />
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                                <span class="icon"><i class="fa-regular fa-star"></i></span>
                            </label>
                        </div>
                        <div class="w-1/2 mx-auto">
                            <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Odeslat recenzi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
