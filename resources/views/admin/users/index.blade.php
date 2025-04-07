@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading">
            <h1 class="heading-title">Uživatelé</h1>

            <aside>
                <a href="{{ route('admin.users.create') }}" class="button-black"><i class="fa-solid fa-plus fa-lg icon"></i> Přidat uživatele</a>
            </aside>
        </div>


        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Jméno
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Přihlašovací údaje
                    </th>
                    <th scope="col" class="px-6 py-3">
                        API token
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Akce
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->login }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->api_token }}
                        </td>
                        <td class="px-6 py-4">
                            {{ \App\Enums\Role::from($user->role)->getName() }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" type="button" class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700">
                                    <i class="fa-solid fa-pencil mr-2"></i> Upravit
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
