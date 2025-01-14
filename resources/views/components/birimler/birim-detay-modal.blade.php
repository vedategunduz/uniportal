@php
    $baslik = '';
    $birim_tipleri_id = 0;
    $isletme_birimleri_id = 0;
    $butonIslemAdi = 'Birim ekle';
    $butonIslemTipi = 'ekle';

    if (!empty($veriler)) {
        $baslik = $veriler->baslik;
        $birim_tipleri_id = $veriler->birim_tipleri_id;
        $isletme_birimleri_id = $veriler->isletme_birimleri_id;
        $butonIslemAdi = 'Birim düzenle';
        $butonIslemTipi = 'duzenle';
    }
@endphp

<form action="" method="POST" id="birimDetayForm">
    <div class="mb-2">
        <label for="baslik">Birim adı</label>
        <input type="text" id="baslik" name="baslik" value="{{ $baslik }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        <input type="hidden" name="isletme_birimleri_id" value="{{ encrypt($isletme_birimleri_id) }}">
    </div>
    <div class="mb-2">
        <label for="birim_tipleri_id">Bağlı olduğu birim</label>
        <select name="birim_tipleri_id" id="birim_tipleri_id"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option value="">Birim türü</option>
            @foreach ($birimTurleri as $rowBirimTur)
                <option value="{{ encrypt($rowBirimTur->birim_tipleri_id) }}"
                    @if ($birim_tipleri_id == $rowBirimTur->birim_tipleri_id) selected @endif>
                    {{ $rowBirimTur->baslik }}</option>
            @endforeach
        </select>
    </div>
    @if ($butonIslemTipi != 'ekle')
        <div class="mb-4">
            <p class="mb-2">Personeller</p>

            <div class="grid md:grid-cols-2 space-x-2">

                <div id="personeller" class="grid order-2 md:order-1 sm:grid-cols-4 lg:grid-cols-5 "></div>

                <div class="relative order-1 md:order-2">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <input type="search" id="default-search"
                            class="block w-full px-4 h-12 text-sm text-gray-900 border border-gray-300 rounded bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Personel ara" required />

                        <input type="hidden" name="search_birimler_id" value="{{ encrypt($isletme_birimleri_id) }}">

                        <button type="button"
                            class="personelleriBirimeEkle text-white absolute end-2.5 bottom-1.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5 pointer-events-none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                        </button>
                    </div>

                    <div class="top-full mt-2 w-full shadow rounded-b bg-gray-50">
                        <form action="">
                            <div id="personelEklemeListesi"
                                class=" px-4 space-y-2 max-h-48 overflow-y-auto hidden-scroll"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    @endif

    <div class="grid grid-cols-2 gap-4">
        <button type="submit" data-button-type="{{ $butonIslemTipi }}"
            class="birimDetayModalSubmit px-3 py-2 text-white rounded @if (!empty($veriler)) {{ 'bg-yellow-400' }}
        @else
        {{ 'bg-green-500 hover:bg-green-600' }} @endif">
            {{ $butonIslemAdi }}
        </button>
        <button type="button" data-modal="birimDetay" class="close-modal px-3 py-2 border rounded">Vazceç</button>
    </div>
</form>
