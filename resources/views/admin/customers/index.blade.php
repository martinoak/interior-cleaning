@extends('admin/layout')

@section('content')
    <div class="heading">
        <div>
            <h1 class="heading-title">Administrace</h1>
            <a href="{{ route('customers.create') }}" class="black"><i class="fa-solid fa-plus fa-lg icon"></i> Zákazník</a>
        </div>
    </div>

    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($customers as $customer)
            <li class="col-span-1 divide-y divide-gray-200 rounded-lg bg-white shadow-sm dark:divide-white/10 dark:bg-gray-800/50 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10">
                <div class="flex w-full items-center justify-between space-x-6 p-6">
                    <div class="flex-1 truncate">
                        <div class="flex items-center space-x-3">
                            <h3 class="truncate text-sm font-medium text-gray-900 dark:text-white">{{ $customer->name }}</h3>
                            @if($customer->variant)
                                <span class="inline-flex shrink-0 items-center rounded-full bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 inset-ring inset-ring-green-600/20 dark:bg-green-500/10 dark:text-green-500 dark:inset-ring-green-500/10">{{ $customer->variant }}</span>
                            @endif
                        </div>
                        @if($customer->message)
                            <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">{{ $customer->message }}</p>
                        @elseif($customer->term)
                            <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">Termín: {{ \Carbon\Carbon::parse($customer->term)->format('j.n.Y') }}</p>
                        @else
                            <p class="mt-1 truncate text-sm text-gray-500 dark:text-gray-400">Nový zákazník</p>
                        @endif
                    </div>
                    @if($customer->term)
                        <div class="flex items-center">
                            <a href="{{ route('archiveCustomer', ['id' => $customer->id]) }}" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                    <path d="M2 3a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H2Z" />
                                    <path fill-rule="evenodd" d="M2 7.5h16l-.811 7.71a2 2 0 0 1-1.99 1.79H4.8a2 2 0 0 1-1.99-1.79L2 7.5ZM7 10a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0v-3Zm5-1a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0v-3a1 1 0 0 0-1-1Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
                <div>
                    <div class="-mt-px flex divide-x divide-gray-200 dark:divide-white/10">
                        @if($customer->email)
                            <div class="flex w-0 flex-1">
                                <a href="mailto:{{ $customer->email }}" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-bl-lg border border-transparent py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-gray-400 dark:text-gray-500">
                                        <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                                        <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                                    </svg>
                                    Email
                                </a>
                            </div>
                        @endif
                        @if($customer->telephone)
                            <div class="{{ $customer->email ? '-ml-px' : '' }} flex w-0 flex-1">
                                <a href="tel:{{ $customer->telephone }}" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 {{ $customer->email ? 'rounded-br-lg' : 'rounded-b-lg' }} border border-transparent py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-gray-400 dark:text-gray-500">
                                        <path d="M2 3.5A1.5 1.5 0 0 1 3.5 2h1.148a1.5 1.5 0 0 1 1.465 1.175l.716 3.223a1.5 1.5 0 0 1-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 0 0 6.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 0 1 1.767-1.052l3.223.716A1.5 1.5 0 0 1 18 15.352V16.5a1.5 1.5 0 0 1-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 0 1 2.43 8.326 13.019 13.019 0 0 1 2 5V3.5Z" clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    Call
                                </a>
                            </div>
                        @endif
                        @if(!$customer->email && !$customer->telephone)
                            <div class="flex w-0 flex-1">
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="relative inline-flex w-0 flex-1 items-center justify-center gap-x-3 rounded-b-lg border border-transparent py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true" class="size-5 text-gray-400 dark:text-gray-500">
                                        <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                        <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
