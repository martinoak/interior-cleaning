<div>
    @for($i = 1; $i <= $counter; $i++)
        <div class="form-row">
            <label for="attachments_{{ $i }}">Příloha k záznamu</label>
            <div class="mt-2 sm:col-span-2 sm:mt-0">
                <div class="flex items-center space-x-4">
                    <input id="attachments_{{ $i }}"
                           type="file"
                           name="attachments[]"
                           autocomplete="off"
                           class="max-w-lg"
                    />
                    <input id="attachment_name_{{ $i }}"
                           type="text"
                           name="attachment-name[]"
                           placeholder="Název přílohy"
                           value="{{ old('attachment_name.'.$i) }}"
                           autocomplete="off"
                           class="max-w-lg"
                    />
                </div>
            </div>
        </div>
        @if($i === $counter)
            <div class="form-row">
                <div></div>
                <div class="mt-2 sm:col-span-2 sm:mt-0">
                    <button type="button" wire:click="addAttachment" class="primary">
                        <i class="fa-solid fa-plus fa-lg icon"></i> Přidat další přílohu
                    </button>
                </div>
            </div>
        @endif
    @endfor
</div>
