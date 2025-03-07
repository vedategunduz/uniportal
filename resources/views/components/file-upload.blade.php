@props([
    'text' => '/Dosya seç veya dosyaları buraya bırak',
    'accept' => 'image/*,.pdf,.doc,.docx,.xls,.xlsx',
    'url' => '',
])

<div data-file-upload title="image/*,.pdf,.doc,.docx,.xls,.xlsx desteklenen formatlar">
    <!-- Dosya ekleme alanı -->
    <div data-file-drop-area>
        <input type="file" name="dosyalar[]" id="dosyalar" class="hidden" accept="{{ $accept }}" multiple
            data-url="{{ $url }}">

        <label for="dosyalar" data-drop-area
            {{ $attributes->merge(['class' => 'border border-dashed rounded border-gray-300 w-full py-6 justify-center flex items-center cursor-pointer']) }}>
            <span class="uppercase text-gray-500 font-medium text-xs">{{ $text }}</span>
        </label>
    </div>

    <!-- Seçilen dosyaların gösterileceği alan -->
    <div data-file-list-container class="py-2 space-y-4 custom-scroll overflow-y-auto"></div>
</div>
