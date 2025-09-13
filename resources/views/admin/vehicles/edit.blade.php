@extends('admin/layout')

@section('content')
    <form method="post" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="api-token" value="{{ auth()->user()->api_token }}">

        <div class="space-y-12 sm:space-y-16">
            <div>
                <h1 class="heading-title">Úpravy vozidla</h1>

                <x-errors :errors="$errors" class="my-4" />

                <div class="form-wrapper">
                    <div class="form-row">
                        <label for="manufacturer">Výrobce *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="manufacturer"
                                   type="text"
                                   name="manufacturer"
                                   autocomplete="off"
                                   value="{{ old('manufacturer', $vehicle->manufacturer) }}"
                                   class="max-w-2xl"
                                   required
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="model">Model *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="model"
                                   type="text"
                                   name="model"
                                   autocomplete="off"
                                   value="{{ old('model', $vehicle->model) }}"
                                   class="max-w-2xl"
                                   required
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="productionYear">Rok výroby *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="productionYear"
                                   type="number"
                                   name="productionYear"
                                   autocomplete="off"
                                   pattern="[0-9]*"
                                   value="{{ old('productionYear', $vehicle->productionYear) }}"
                                   class="max-w-2xl"
                                   required
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="spz">SPZ *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="spz"
                                   type="text"
                                   name="spz"
                                   autocomplete="off"
                                   value="{{ old('spz', $vehicle->spz) }}"
                                   class="max-w-2xl"
                                   required
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="vin">VIN</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="vin"
                                   type="text"
                                   name="vin"
                                   autocomplete="off"
                                   value="{{ old('vin', $vehicle->vin) }}"
                                   class="max-w-2xl"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="color">Barva *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="color"
                                   type="color"
                                   name="color"
                                   autocomplete="off"
                                   value="{{ old('color', $vehicle->color) }}"
                                   class="max-w-2xl h-10"
                                   required
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="type">Typ *</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div class="grid grid-cols-1 sm:max-w-xs">
                                <select id="type" name="type" autocomplete="off" class="max-w-2xl" required>
                                    <option value="" hidden>Vyber typ</option>
                                    @foreach(\App\Enums\VehicleType::cases() as $type)
                                        <option value="{{ $type->value }}" @selected(old('type', $vehicle->type) == $type->value)>
                                            {{ $type->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down col-start-1 row-start-1 mr-2 self-center justify-self-end text-gray-500 dark:text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    {{--<div class="form-row">
                        <label for="vtp">Velký technický průkaz</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div class="flex max-w-2xl justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10 dark:border-white/25">
                                <div class="text-center">
                                    <svg viewBox="0 0 24 24" fill="currentColor" data-slot="icon" aria-hidden="true" class="mx-auto size-12 text-gray-300 dark:text-gray-600">
                                        <path d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clip-rule="evenodd" fill-rule="evenodd" />
                                    </svg>
                                    <div class="mt-4 flex text-sm/6 text-gray-600 dark:text-gray-400">
                                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-primary-600 focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-primary-600 hover:text-primary-500 dark:bg-transparent dark:text-primary-400 dark:focus-within:outline-primary-500 dark:hover:text-primary-300">
                                            <span>Upload a file</span>
                                            <input id="file-upload" type="file" name="vtp" class="sr-only" />
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <div id="file-name-display" class="mt-2 text-sm font-medium text-gray-900 dark:text-white hidden">
                                        Vybráno: <span id="selected-file-name"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>

            <div>
                <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Hlídané termíny</h2>
                <p class="mt-1 max-w-2xl text-sm/6 text-gray-600 dark:text-gray-400">Vyplněné datumy jsou automaticky hlídané a v případě blížícího se termínu se pošle e-mail.</p>

                <div class="form-wrapper">
                    <div class="form-row">
                        <label for="stk">STK</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="stk"
                                   type="date"
                                   name="stk"
                                   value="{{ old('stk', $vehicle->stk?->format('Y-m-d')) }}"
                                   autocomplete="off"
                                   class="max-w-2xl"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="oilChange">Výměna oleje</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="oilChange"
                                   type="date"
                                   name="oilChange"
                                   value="{{ old('oilChange', $vehicle->oilChange?->format('Y-m-d')) }}"
                                   autocomplete="off"
                                   class="max-w-2xl"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="insurance">Povinné ručení</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="insurance"
                                   type="date"
                                   name="insurance"
                                   value="{{ old('insurance', $vehicle->insurance?->format('Y-m-d')) }}"
                                   autocomplete="off"
                                   class="max-w-2xl"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="tachograph">Tachograf</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="tachograph"
                                   type="date"
                                   name="tachograph"
                                   value="{{ old('tachograph', $vehicle->tachograph?->format('Y-m-d')) }}"
                                   autocomplete="off"
                                   class="max-w-2xl"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="spneu">Letní pneu</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="spneu"
                                   type="number"
                                   name="spneu"
                                   class="max-w-2xl"
                                   value="{{ old('spneu', $vehicle->spneu) }}"
                                   autocomplete="off"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                            />
                        </div>
                    </div>

                    <div class="form-row">
                        <label for="wpneu">Zimní pneu</label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <input id="wpneu"
                                   type="number"
                                   name="wpneu"
                                   class="max-w-2xl"
                                   value="{{ old('wpneu', $vehicle->wpneu) }}"
                                   autocomplete="off"
                                   inputmode="numeric"
                                   pattern="[0-9]*"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Zrušit</button>
            <button type="submit" class="primary w-1/6 h-12">Uložit vozidlo</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file-upload');
            const fileNameDisplay = document.getElementById('file-name-display');
            const selectedFileName = document.getElementById('selected-file-name');

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    selectedFileName.textContent = file.name;
                    fileNameDisplay.classList.remove('hidden');
                } else {
                    fileNameDisplay.classList.add('hidden');
                    selectedFileName.textContent = '';
                }
            });
        });
    </script>
@endsection
