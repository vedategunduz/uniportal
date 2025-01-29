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

<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> Birim İşlemleri </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<div class="ozelBoyut"></div>

<form action="" method="POST" id="birimDetayForm" class="p-6">
    <input type="hidden" name="isletme_birimleri_id" value="{{ encrypt($isletme_birimleri_id) }}">
    {{-- INPUT Etkinlik başlığı --}}
    <div class="relative">
        <input type="text" name="baslik" id="baslik"
            class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" " value="{{ $baslik }}" />
        <label for="baslik"
            class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
            Birim adı
        </label>
    </div>
    <div class="mb-2">
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
