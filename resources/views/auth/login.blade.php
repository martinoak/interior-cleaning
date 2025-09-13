@extends('admin/layout', ['offset' => false])

@section('content')
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a class="flex items-center mb-6 text-2xl">
            <img class="h-12 mr-2" src="{{ asset('images/logo/logo-car.png') }}" alt="logo">
        </a>
        <div class="w-full rounded-lg shadow-xs dark:border dark:border-gray-500 md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="space-y-4 md:space-y-6" action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div>
                        <label for="login" class="block mb-2 text-sm font-medium text-gray-900">Jméno</label>
                        <input type="text" name="login" id="login" value="{{ old('name') }}" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Heslo</label>
                        <input type="password" name="password" id="password" value="{{ old('password') }}" required>
                    </div>
                    <div class="w-1/2 mx-auto">
                        <button type="submit" class="w-full text-white bg-primary-800 hover:bg-primary-900 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Přihlásit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
