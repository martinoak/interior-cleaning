@extends('admin/layout')

@section('content')
    <h1 class="heading-title">Editace uživatele</h1>

    <x-errors :errors="$errors" />

    <div class="mx-auto pb-6">
        <form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="space-y-12 sm:space-y-16">
                <div>
                    <div class="form-offset">
                        <div class="row-wrapper">
                            <label for="name">Jméno</label>
                            <div>
                                <input type="text" name="name" id="name" autocomplete="off" value="{{ old('name', $user->name) }}" class="users-input max-w-2xl" required>
                            </div>
                        </div>

                        <div class="row-wrapper">
                            <label for="login">Přihlašovací jméno</label>
                            <div>
                                <input type="text" name="login" id="login" autocomplete="off" value="{{ old('login', $user->login) }}" class="users-input max-w-2xl" required>
                            </div>
                        </div>

                        <div class="row-wrapper">
                            <label for="role">Role</label>
                            <div>
                                <ul class="grid w-full gap-6 grid-cols-3 mt-2">
                                    @foreach(\App\Enums\Role::cases() as $type)
                                        <li>
                                            <input type="radio" id="{{ $type->value }}" name="role" value="{{ $type->value }}" @checked(old('role', $user->role) === $type->value) class="hidden peer" required />
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
                <button type="submit" class="primary">Uložit</button>
            </div>
        </form>
    </div>
@endsection
