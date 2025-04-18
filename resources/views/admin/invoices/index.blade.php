@extends('admin/admin-layout')

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading">
            <div>
                <h1 class="heading-title">Faktury</h1>
                <aside class="flex gap-4">
                    <a href="{{ route('invoices.export') }}"><button class="button-green"><i class="fa-regular fa-file-excel fa-lg text-white icon"></i>Export</button></a>
                    <a href="{{ route('invoices.create') }}" class="button-black"><i class="fa-solid fa-plus fa-lg icon"></i> Faktura</a>
                </aside>
            </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Zákazník
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Typ
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Datum
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Cena
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Akce
                    </th>
                </tr>
                </thead>
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
                                <a href="{{ route('vouchers.show', ['voucher' => $invoice->name]) }}" class="cursor-pointer text-white bg-amber-700 hover:bg-amber-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-amber-600 dark:hover:bg-amber-700" @if(! file_exists(storage_path('app/public/voucher/').$invoice->name.'png')) disabled @endif>
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endif
                            <a href="{{ route('invoices.show', ['invoice' => $invoice->id]) }}" class="cursor-pointer text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700">
                                <i class="fa-solid fa-download"></i>
                            </a>
                            <a href="{{ route('invoices.edit', ['invoice' => $invoice->id]) }}" class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
