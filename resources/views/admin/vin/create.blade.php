@extends('admin/layout')

@section('content')
    <form method="post" action="{{ route('vin.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="api-token" value="{{ auth()->user()->api_token }}">

        <div class="space-y-12 sm:space-y-16">
            <div>
                <h1 class="heading-title">Nové VIN</h1>

                <x-errors :errors="$errors" />

                <div class="form-wrapper">
                    <div class="form-row">
                        <label for="vin">VIN *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="vin"
                                   type="text"
                                   name="vin"
                                   autocomplete="off"
                                   value="{{ old('vin') }}"
                                   class="max-w-2xl"
                                   required
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="name">Vlastník auta *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="name"
                                   type="text"
                                   name="name"
                                   autocomplete="off"
                                   value="{{ old('name') }}"
                                   class="max-w-2xl"
                                   required
                            />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="button" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Zrušit</button>
                    <button type="submit" class="primary w-1/6 h-12">Uložit VIN</button>
                </div>
            </div>
        </div>
    </form>
@endsection
