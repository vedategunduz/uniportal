@props([
    'text' => '/Dosya seç veya dosyaları buraya bırak',
    'accept' => 'image/*',
])

<div data-file-upload>
    <!-- Dosya ekleme alanı -->
    <div data-file-drop-area>
        <input type="file" name="dosyalar[]" id="dosyalar" class="hidden" accept="{{ $accept }}" multiple>

        <label for="dosyalar" data-drop-area
            {{ $attributes->merge(['class' => 'border border-dashed rounded border-gray-300 w-full py-6 justify-center flex items-center cursor-pointer']) }}>
            <span class="uppercase text-gray-500 font-medium text-xs">{{ $text }}</span>
        </label>
    </div>

    <!-- Seçilen dosyaların gösterileceği alan -->
    <div data-file-list-container class="p-4 space-y-4 custom-scroll overflow-y-auto"></div>
</div>
