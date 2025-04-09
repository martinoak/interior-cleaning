<div>
    @for($i = 1; $i <= $counter; $i++)
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="attachments">Příloha k záznamu</label>
            <div class="flex items-center space-x-4">
                <input class="block w-1/3 h-10 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-hidden dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="attachments" type="file" name="attachments[]">
                <input type="text" class="form-input w-2/3" name="attachment-name[]" placeholder="Název přílohy" value="{{ old('attachment_name.'.$i) }}">
            </div>
        </div>
        @if($i === $counter)
            <button type="button" wire:click="addAttachment" class="button-indigo mb-5">
                <i class="fa-solid fa-plus fa-lg icon"></i> Přidat další přílohu
            </button>
        @endif
    @endfor
</div>
