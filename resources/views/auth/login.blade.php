@extends('admin/admin-layout')

@section('head')
    <meta name="viewport" content="user-scalable=no">
    <link rel="stylesheet" href="{{ asset('css/tailwind.css') . '?m=' . filemtime(public_path('css/tailwind.css')) }}" />
    <style>body{ background-color:rgb(17,24,39);}</style>
@endsection

@section('content')
<section class="bg-gray-900">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a class="flex items-center mb-6 text-2xl">
            <img class="h-12 mr-2" src="{{ asset('images/logo/logo-car.png') }}" alt="logo">
        </a>
        <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div>
                        <label for="login" class="block mb-2 text-sm font-medium text-gray-900">Jméno</label>
                        <input type="text" name="login" id="login" value="{{ old('name') }}" class="border border-gray-300 text-white bg-gray-700 sm:text-sm rounded-lg block w-full p-2.5" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Heslo</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" class="border border-gray-300 text-white bg-gray-700 sm:text-sm rounded-lg block w-full p-2.5" required>
                    </div>
                    <div class="w-1/2 mx-auto">
                        <button type="submit" class="w-full text-white bg-gray-800 hover:bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Přihlásit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
