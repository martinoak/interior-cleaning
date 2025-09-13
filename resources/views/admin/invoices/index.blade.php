@extends('admin/layout')

@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <h1 class="heading-title sm:flex-auto">Faktury</h1>
            <div class="mt-4 sm:mt-0 sm:ml-16 flex space-x-4">
                <a href="{{ route('invoices.export') }}">
                    <button class="green"><i class="fa-regular fa-file-excel fa-lg text-white icon"></i>
                        Export
                    </button>
                </a>
                <a href="{{ route('invoices.create') }}" class="black"><i class="fa-solid fa-plus fa-lg icon"></i>
                    Faktura
                </a>
            </div>
        </div>

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="relative min-w-full divide-y divide-gray-300 dark:divide-white/15">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-0 dark:text-white">Zákazník</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Typ</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Datum</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Cena</th>
                            <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-0">
                                <span class="sr-only">Akce</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-0 dark:text-white">{{ $invoice->name }}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{!! \App\Enums\InvoiceTypes::getHtmlSpan($invoice->type) !!}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ Carbon\Carbon::parse($invoice->date)->format('j.n.Y') }}</td>
                                    <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">{{ $invoice->price }},-</td>
                                    <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-0">
                                        @if($invoice->type === 'P' && file_exists(storage_path('app/public/voucher/').$invoice->name.'.png'))
                                            <a href="{{ route('vouchers.show', ['voucher' => $invoice->name]) }}"
                                               class="cursor-pointer text-white bg-amber-700 hover:bg-amber-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-amber-600 dark:hover:bg-amber-700"
                                               @if(! file_exists(storage_path('app/public/voucher/').$invoice->name.'png')) disabled @endif>
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}"
                                           class="cursor-pointer text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}"
                                           class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700">
                                            <i class="fa-solid fa-pencil"></i>
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


    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

            <tbody>
            @foreach($invoices as $invoice)
                <tr class="odd:bg-white dark:odd:bg-gray-900 even:bg-gray-200 dark:even:bg-gray-800 border-b dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $invoice->name }}
                    </th>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {!! \App\Enums\InvoiceTypes::getHtmlSpan($invoice->type) !!}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ Carbon\Carbon::parse($invoice->date)->format('j.n.Y') }}
                    </td>
                    <td class="px-6 py-4 font-bold whitespace-nowrap">
                        {{ $invoice->price }},-
                    </td>
                    <td class="px-6 py-4 flex gap-2">
                        @if($invoice->type === 'P' && file_exists(storage_path('app/public/voucher/').$invoice->name.'.png'))
                            <a href="{{ route('vouchers.show', ['voucher' => $invoice->name]) }}"
                               class="cursor-pointer text-white bg-amber-700 hover:bg-amber-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-amber-600 dark:hover:bg-amber-700"
                               @if(! file_exists(storage_path('app/public/voucher/').$invoice->name.'png')) disabled @endif>
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        @endif
                        <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}"
                           class="cursor-pointer text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700">
                            <i class="fa-solid fa-download"></i>
                        </a>
                        <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}"
                           class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
