{layout '../../../layout.latte'}

@section('content')
    <div class="p-4 sm:ml-64">
        <div class="heading justify-start">
            <a href="{{ route('service-book.index') }}" class="button-indigo" type="button">
                <i class="fa-solid fa-arrow-left fa-lg icon"></i> Zpět
            </a>
            <h1 class="heading-title">Nový záznam</h1>
        </div>

        <form method="post" action="{{ route('service-book.store', ['vehicle' => $vehicle->id]) }}">
            @csrf
            <input type="hidden" name="api-token" value="{{ auth()->user()->api_token }}">
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

            <div class="mb-5">
                <label for="title" class="form-label">Název opravy <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-input" required>
            </div>

            <div class="mb-5">
                <label for="note" class="form-label">Poznámka</label>
                <textarea name="note" id="note" rows="4" class="form-input">{{ old('note') }}</textarea>
            </div>

            <div class="mb-5">
                <label for="price" class="form-label">Cena opravy</label>
                <input type="number" name="price" id="price" class="form-input" inputmode="numeric" pattern="[0-9]*" value="{{ old('price') }}">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Částka se přičte do ročního záznamu.</p>
            </div>

            <div class="mb-5">
                <label for="hours" class="form-label">Odpracováno hodin</label>
                <input type="number" name="hours" id="hours" class="form-input" inputmode="numeric" pattern="[0-9]*" value="{{ old('hours') }}">
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Hodiny se přičtou do ročního záznamu.</p>
            </div>

            <div class="mb-5">
                <label for="service_date" class="form-label">Datum provedení práce <i class="fa-solid fa-asterisk text-red-600"></i></label>
                <input type="date" name="service_date" id="service_date" value="{{ old('service_date', date('Y-m-d')) }}" class="form-input" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="form-submit">Přidat záznam</button>
                <button type="reset" class="form-reset">Vymazat</button>
            </div>
        </form>
    </div>
@endsection
