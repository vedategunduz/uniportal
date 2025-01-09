@php
    $baslik = '';
    $birim_tipleri_id = 0;
    $isletme_birimleri_id = 0;
    $butonIslemAdi = 'Birim ekle';

    if (!empty($veriler)) {
        $baslik = $veriler->baslik;
        $birim_tipleri_id = $veriler->birim_tipleri_id;
        $isletme_birimleri_id = $veriler->isletme_birimleri_id;
        $butonIslemAdi = 'Birim düzenle';
    }
@endphp

<form action="" method="POST">
    <div class="mb-2">
        <label for="baslik">Birim adı</label>
        <input type="text" id="baslik" name="baslik" value="{{ $baslik }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <input type="hidden" name="isletme_birimleri_id" value="{{ encrypt($isletme_birimleri_id) }}">
    </div>
    <div class="mb-2">
        <label for="birim_tipleri_id">Bağlı olduğu birim</label>
        <select name="" id="birim_tipleri_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Birim türü</option>
            @foreach ($birimTurleri as $rowBirimTur)
                <option value="{{ $rowBirimTur->birim_tipleri_id }}" @if ($birim_tipleri_id == $rowBirimTur->birim_tipleri_id) selected @endif>
                    {{ $rowBirimTur->baslik }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <p class="mb-2">Personeller</p>

        <div class="flex space-x-2">

            <div id="personeller" class="flex space-x-2"></div>

            <button type="button" class="border rounded-full size-12 bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6 mx-auto">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
        </div>

    </div>

    <div class="grid grid-cols-2 gap-4">
        <button type="button" class="px-3 py-2 border">Vazceç</button>
        <button type="submit"
            class="px-3 py-2 border text-white @if (!empty($veriler)) {{ 'bg-yellow-400' }}
        @else
        {{ 'bg-green-500 hover:bg-green-600' }} @endif">
            {{ $butonIslemAdi }}
        </button>
    </div>
</form>
