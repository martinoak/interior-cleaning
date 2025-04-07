@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <a href="{{ route('admin.users.index') }}" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg text-white mr-1"></i> Zpět
            </a>
            <h1 class="heading-title">Nový uživatel</h1>
        </div>

        <x-errors :errors="$errors" />

        <main class="px-5">
            <div class="mx-auto pb-6">
                <form id="event" action="{{ route('admin.users.store') }}" method="post">
                    @csrf
                    <div class="space-y-12 sm:space-y-16">
                        <div>
                            <div class="form-offset">
                                <div class="row-wrapper">
                                    <label for="name">Jméno</label>
                                    <div>
                                        <input type="text" name="name" id="name" autocomplete="off" value="{{ old('name') }}" class="users-input max-w-2xl" required>
                                    </div>
                                </div>

                                <div class="row-wrapper">
                                    <label for="login">Přihlašovací jméno</label>
                                    <div>
                                        <input type="text" name="login" id="login" autocomplete="off" value="{{ old('login') }}" class="users-input max-w-2xl" required>
                                    </div>
                                </div>

                                <div class="row-wrapper">
                                    <label for="password">Heslo</label>
                                    <div>
                                        <input id="password" type="password" name="password" value="{{ old('password') }}" class="users-input max-w-2xl">
                                        <p class="helper-text">Heslo se zahashuje bcryptem.</p>
                                    </div>
                                </div>

                                <div class="row-wrapper">
                                    <label for="role">Role</label>
                                    <div>
                                        <ul class="grid w-full gap-6 grid-cols-3 mt-2">
                                            @foreach(\App\Enums\Role::cases() as $type)
                                                <li>
                                                    <input type="radio" id="{{ $type->value }}" name="role" value="{{ $type->value }}" class="hidden peer" required />
                                                    <label for="{{ $type->value }}" class="vehicle-type">
                                                        <div class="block">
                                                            <div class="w-full text-lg font-semibold">
                                                                <i class="{{ $type->getIcon() }} fa-lg mr-2"></i> {{ $type->getName() }}
                                                            </div>
                                                        </div>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="button-blue">Uložit</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
