@if($errors->any())
    <div class="bg-red-600 rounded-lg p-4 my-4" role="alert">
        <h2 class="mb-2 text-lg font-semibold text-white">Formulář obsahuje chyby!</h2>
        <ul class="max-w-md space-y-1 text-white list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
