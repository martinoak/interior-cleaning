@extends('admin/layout')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <h1 class="heading-title sm:flex-auto">Uživatelé</h1>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('admin.users.create') }}" class="black"><i class="fa-solid fa-plus fa-lg icon"></i> Přidat uživatele</a>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">Jméno</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Přihlašovací údaje</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">API token</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Role</th>
                                <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-0">
                                    <span class="sr-only">Akce</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">{{ $user->name }}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $user->login }}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $user->api_token }}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ \App\Enums\Role::from($user->role)->getName() }}</td>
                                    <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                        <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}"
                                           class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300">
                                            Upravit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
