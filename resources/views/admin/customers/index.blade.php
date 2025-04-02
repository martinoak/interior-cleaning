@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading">
            <div>
                <h1 class="heading-title">Administrace</h1>
                <a href="{{ route('customers.create') }}" class="button-black"><i class="fa-solid fa-plus fa-lg icon"></i> Zákazník</a>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 mb-4">
            @foreach($customers as $customer)
                <div class="cell">
                    <div class="cell-content justify-between">
                        <h2 class="cell-title">
                            {{ $customer->name }} @if($customer->variant)<span class="text-lg text-gray-500">| {{ $customer->variant }}</span> @endif
                        </h2>
                        <div class="hidden sm:flex flex-row justify-end items-center gap-4 mr-2">
                            @if($customer->telephone)
                                <a class="button-blue" href="tel:{{ $customer->telephone }}"><i class="fa-solid fa-mobile-screen fa-xl icon"></i>Zavolat</a>
                            @else
                                <span class="button-disabled"><i class="fa-solid fa-mobile-screen fa-xl icon"></i>Telefon</span>
                            @endif
                            @if($customer->email)
                                <a class="button-blue" href="mailto:{{ $customer->email }}"><i class="fa-solid fa-at fa-xl icon"></i>Napsat e-mail</a>
                            @else
                                <span class="button-disabled"><i class="fa-solid fa-at fa-xl icon"></i>E-mail</span>
                            @endif
                            @if(! $customer->variant)
                                <form method="post" action="{{ route('customers.update', ['customer' => $customer->id]) }}" class="flex gap-4">
                                    @csrf
                                    @method('PUT')
                                    @foreach(App\Enums\CleaningTypes::cases() as $case)
                                        <button type="submit" name="variant" value="{{ $case->value }}" class="button-yellow">
                                            <i class="fa-solid fa-{{ $loop->iteration }} icon"></i> {{ $case->value }}
                                        </button>
                                    @endforeach
                                </form>
                            @endif
                            @if($customer->term)
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="button-green">{{ \Carbon\Carbon::parse($customer->term)->format('j.n.Y') }}</a>
                            @else
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="button-green"><i class="fa-solid fa-plus fa-xl icon"></i> Objednat</a>
                            @endif
                            @if($customer->term)
                                <a href="{{ route('archiveCustomer', ['id' => $customer->id]) }}" class="button-yellow"><i class="fa-solid fa-inbox fa-xl"></i></a>
                            @else
                                <span class="button-disabled"><i class="fa-solid fa-inbox fa-xl"></i></span>
                            @endif
                            <button data-modal-target="destroy-{{ $customer->id }}" data-modal-toggle="destroy-{{ $customer->id }}" class="button-red">
                                <i class="fa-solid fa-trash-can fa-xl"></i>
                            </button>
                        </div>
                        <div id="destroy-{{ $customer->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="destroy-{{ $customer->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Opravdu kompletně smazat uživatele<br> <strong>{{ $customer->name }}</strong>?</h3>
                                        <form action="{{ route('customers.destroy', ['customer' => $customer->id]) }}" method="post" class="flex justify-around">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button-red w-[120px]"><i class="fa-solid fa-trash-can icon"></i> Smazat</button>
                                            <button data-modal-hide="destroy-{{ $customer->id }}" type="button" class="button-black w-[120px]"><i class="fa-solid fa-xmark icon"></i> Zrušit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(! empty($customer->message))
                        <p class="cell-note">{{ nl2br($customer->message) }}</p>
                    @endif
                    <div class="cell-note-mobile">
                        <section>
                            @if($customer->telephone)
                                <a class="button-blue w-1/2" href="tel:{{ $customer->telephone }}"><i class="fa-solid fa-mobile-screen fa-xl icon"></i></a>
                            @else
                                <span class="button-disabled w-1/2"><i class="fa-solid fa-mobile-screen fa-xl icon"></i></span>
                            @endif
                            @if($customer->email)
                                <a class="button-blue w-1/2" href="mailto:{{ $customer->email }}"><i class="fa-solid fa-at fa-xl icon"></i></a>
                            @else
                                <span class="button-disabled w-1/2"><i class="fa-solid fa-at fa-xl icon"></i></span>
                            @endif
                        </section>
                        <section>
                            @if(! $customer->variant)
                                <form method="post" action="{{ route('customers.update', ['customer' => $customer->id]) }}" class="flex w-full space-x-2 justify-between">
                                    @csrf
                                    @method('PUT')
                                    @foreach(App\Enums\CleaningTypes::cases() as $case)
                                        <button type="submit" name="variant" value="{{ $case->value }}" style="@if($loop->first)margin-left: 0 !important;@endif" class="w-1/3 button-yellow">
                                             {{ $case->getShortenedTitle() }}
                                        </button>
                                    @endforeach
                                </form>
                            @endif
                        </section>
                        <section>
                            @if($customer->term)
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="button-green">{{ Carbon\Carbon::parse($customer->term)->format('j.n.Y') }}</a>
                            @else
                                <a href="{{ route('customers.edit', ['customer' => $customer->id]) }}" class="button-green"><i class="fa-solid fa-plus fa-xl icon"></i> Objednat</a>
                            @endif
                            <div class="flex space-x-2">
                                @if($customer->term)
                                    <a href="{{ route('archiveCustomer', ['id' => $customer->id]) }}" class="button-yellow"><i class="fa-solid fa-inbox fa-xl"></i></a>
                                @else
                                    <span class="button-disabled w-1/2"><i class="fa-solid fa-inbox fa-xl"></i></span>
                                @endif
                                <button data-modal-target="destroy-{{ $customer->id }}" data-modal-toggle="destroy-{{ $customer->id }}" class="button-red">
                                    <i class="fa-solid fa-trash-can fa-xl"></i>
                                </button>
                            </div>
                        </section>
                        <div id="destroy-{{ $customer->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="destroy-{{ $customer->id }}">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Opravdu smazat uživatele<br> <strong>{{ $customer->name }}</strong>?</h3>
                                        <form action="{{ route('customers.destroy', ['customer' => $customer->id]) }}" method="post" class="flex justify-around">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="button-red w-[120px]"><i class="fa-solid fa-trash-can icon"></i> Smazat</button>
                                            <button data-modal-hide="destroy-{{ $customer->id }}" type="button" class="button-black w-[120px]"><i class="fa-solid fa-xmark icon"></i> Zrušit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="inline-flex items-center justify-center w-full mt-[100px]" id="archiv">
        <hr class="w-96 h-1 my-8 bg-gray-300 border-0">
        <span class="absolute px-3 font-black text-gray-900 text-xl -translate-x-1/2 bg-gray-50 dark:bg-gray-900 left-1/2 dark:text-white">Archiv</span>
    </div>
    <div class="p-4 sm:ml-64">
        <div class="grid grid-cols-1 gap-4 mb-4">
            @foreach($archived as $customer)
                <div class="cell">
                    <div class="cell-content justify-between">
                        <h2 class="cell-title">
                            {{ $customer->name }} @if($customer->variant)<span class="text-lg text-gray-500">| {{ $customer->variant }}</span>@endif
                        </h2>
                        <div class="hidden sm:flex flex-row justify-end items-center gap-4 mr-2">
                            @if($customer->telephone)
                                <a class="button-blue" href="tel:{{ $customer->telephone }}"><i class="fa-solid fa-mobile-screen fa-xl icon"></i>Zavolat</a>
                            @endif
                            @if($customer->email)
                                <a class="button-blue" href="mailto:{{ $customer->email }}"><i class="fa-solid fa-at fa-xl icon"></i>Napsat e-mail</a>
                            @endif
                            @if(! $customer->feedbackSent && $customer->variant)
                                <a href="{{ route('feedback', ['id' => $customer->id, 'email' => $customer->email, 'variant' => $customer->variant]) }}" class="button-indigo"><i class="fa-solid fa-paper-plane fa-lg text-white icon"></i>Feedback</a>
                            @endif
                            @if(! $customer->variant)
                                <button class="button-red"><i class="fa-solid fa-gear fa-lg text-white icon"></i>Varianta</button>
                            @endif
                            @if($customer->variant && $customer->feedbackSent)
                                <span class="button-green"><i class="fa-solid fa-user-check icon"></i> OK</span>
                            @endif
                        </div>
                    </div>
                    @if(! empty($customer->message))
                        <p class="cell-note">{{ nl2br($customer->message) }}</p>
                    @endif
                    <div class="cell-note-mobile">
                        <section>
                            @if($customer->telephone)
                                <a class="button-blue w-1/2" href="tel:{{ $customer->telephone }}"><i class="fa-solid fa-mobile-screen fa-xl icon"></i></a>
                            @endif
                            @if($customer->email)
                                <a class="button-blue w-1/2" href="mailto:{{ $customer->email }}"><i class="fa-solid fa-at fa-xl icon"></i></a>
                            @endif
                        </section>

                        @if(! $customer->feedbackSent && $customer->variant)
                            <a href="{{ route('feedback', ['id' => $customer->id, 'email' => $customer->email, 'variant' => $customer->variant]) }}" class="button-indigo"><i class="fa-solid fa-paper-plane fa-lg text-white icon"></i>Feedback</a>
                        @endif
                        @if(! $customer->variant)
                            <button class="button-red"><i class="fa-solid fa-gear fa-lg text-white icon"></i>Varianta</button>
                        @endif
                        @if($customer->variant && $customer->feedbackSent)
                            <span class="button-green"><i class="fa-solid fa-user-check icon"></i> OK</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
