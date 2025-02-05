@php
    $baslik = 'Ziyaret Oluştur';
    $etkinlikBaslik = '';
    $etkinlikBaslamaTarihi = '';
    $etkinlikBitisTarihi = '';
    $gidenIsletmelerId = 0;
    $gidilenIsletmelerId = 0;
    $buton = 'Ziyaret Oluştur';
    $eventType = 'ekle';

    if (!empty($etkinlik)) {
        $baslik = 'Ziyaret Düzenle';
        $etkinlikBaslik = $etkinlik->baslik;
        $etkinlikBaslamaTarihi = $etkinlik->etkinlikBaslamaTarihi;
        $etkinlikBitisTarihi = $etkinlik->etkinlikBitisTarihi;
        $gidenIsletmelerId = $etkinlik->giden_isletme;
        $gidilenIsletmelerId = $etkinlik->gidilen_isletme;
        $buton = 'Ziyaret Düzenle';
        $eventType = 'duzenle';
    }
@endphp

<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> {{ $baslik }} </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="">
    @if (!empty($etkinlik))
        <input type="hidden" name="etkinlikler_id" value="{{ encrypt($etkinlik->etkinlikler_id) }}">
    @endif
    <section class="flex flex-col gap-4 p-4" style="height: 80vh;">
        {{-- INPUT Etkinlik başlığı --}}
        <div class="relative">
            <input type="text" name="baslik" id="baslik"
                class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " value="{{ $etkinlikBaslik }}" />
            <label for="baslik"
                class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                Ziyaret adı
            </label>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                class="bg-blue-700 font-medium text-white text-sm rounded flex items-center justify-center col-span-2 lg:col-span-1 p-2.5">
                <span>Başvuru Başlangıç/Bitiş</span>
            </div>
            {{-- INPUT Etkinlik başvuru başlangıç tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBaslamaTarihi" value="{{ $etkinlikBaslamaTarihi }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            {{-- INPUT Etkinlik başvuru bitiş tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBitisTarihi" value="{{ $etkinlikBitisTarihi }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
        </div>

        <div class="">
            <textarea id="aciklama" name="aciklama" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ziyaret açıklaması...">{{ $etkinlik->aciklama ?? '' }}</textarea>

        </div>

        <div class="grid lg:grid-cols-2 mb-4 gap-4 ">
            <div class="space-y-4">
                <h5>Ziyaret Eden Kurum</h5>
                <select name="olusturan_isletmeler_id" id="olusturan_isletmeler_id" @class([
                    'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ])>
                    @foreach ($isletmeler as $isletme)
                        <option @if ($isletme->isletmeler_id == $gidenIsletmelerId) selected @endif
                            value="{{ encrypt($isletme->isletmeler_id) }}">
                            {{ $isletme->baslik }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="search" id="search" placeholder="Ara..."
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                <div class="relative">
                    <div id="gidecekPersoneller"
                        class="max-h-80 space-y-4 overflow-y-auto px-4 absolute top-0 left-0 bg-gray-50 z-20 w-full shadow rounded">
                    </div>
                </div>

                <h2 class="font-medium text-lg border-b mb-4">
                    <span>Ziyaret Ekibi</span><span class="text-xs font-normal">(İletişim bilgileriniz
                        paylaşılacaktır.)</span>
                </h2>
                <div id="selectedPersonel" class="space-y-2 pb-12 max-h-80 overflow-y-auto">
                    @if (!empty($etkinlik))
                        @foreach ($etkinlik->gidenKullanicilar as $kullanici)
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="kullanicilar_id[]"
                                    value="{{ encrypt($kullanici->bilgi->kullanicilar_id) }}">
                                <img src="{{ $kullanici->bilgi->profilFotoUrl }}"
                                    class="size-14 object-contain rounded-full" alt="">

                                <div class="flex flex-col">
                                    <span
                                        class="font-semibold">{{ $kullanici->bilgi->ad . ' ' . $kullanici->bilgi->soyad }}</span>
                                    <span class="text-xs text-gray-500">{{ $kullanici->bilgi->telefon }}</span>
                                    <span class="text-xs text-gray-500">{{ $kullanici->bilgi->email }}</span>
                                </div>

                                <button type="button" class="ml-auto removeSelectedGidenPersonelEmail"
                                    data-email="{{ $kullanici->bilgi->email }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x size-6" viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="space-y-4">
                <h5>Ziyaret Edilen Kurum</h5>
                <select name="gidilen_isletmeler_id" id="gidilen_isletmeler_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Kurum seçiniz...</option>
                    @foreach ($tumIsletmeler as $tumIsletme)
                        <option @if ($tumIsletme->isletmeler_id == $gidilenIsletmelerId) selected @endif
                            value="{{ encrypt($tumIsletme->isletmeler_id) }}">
                            {{ $tumIsletme->baslik }}</option>
                    @endforeach
                </select>
                <input type="text" name="otherSearch" id="otherSearch" placeholder="Kurum seçiniz"
                    @if (empty($etkinlik)) disabled @endif
                    class="disabled:bg-gray-200 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                <div class="relative">
                    <div id="gidilecekPersoneller"
                        class="max-h-80 space-y-4 overflow-y-auto px-4 absolute top-0 left-0 bg-gray-50  z-20 w-full shadow rounded">
                    </div>
                </div>

                <h2 class="font-medium text-lg border-b mb-4">Kurum Ekibi</h2>
                <div id="selectedGidilecekPersonel" class="space-y-2 pb-12 max-h-80 overflow-y-auto">
                    @if (!empty($etkinlik))
                        @foreach ($etkinlik->gidilenKullanicilar as $kullanici)
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="davet_kullanicilar_id[]"
                                    value="{{ encrypt($kullanici->bilgi->kullanicilar_id) }}">
                                <img src="{{ $kullanici->bilgi->profilFotoUrl }}"
                                    class="size-14 object-contain rounded-full" alt="">

                                <div class="flex flex-col">
                                    <span class="font-medium text-sm">{{ $kullanici->bilgi->anaUnvan->baslik }}</span>
                                    <span
                                        class="text-xs text-gray-500">{{ $kullanici->bilgi->ad . ' ' . $kullanici->bilgi->soyad }}</span>
                                    <span class="text-xs text-gray-500">{{ $kullanici->bilgi->telefon }}</span>
                                    <span class="text-xs text-gray-500">{{ $kullanici->bilgi->email }}</span>
                                </div>

                                <button type="button" class="ml-auto removeSelectedDavetPersonelEmail"
                                    data-email="{{ $kullanici->bilgi->email }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-x size-6" viewBox="0 0 16 16">
                                        <path
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-auto pb-4">
            <button type="submit" data-event-type="{{ $eventType }}"
                class="w-full bg-blue-700 text-white text-sm rounded px-4 py-2.5 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                {{ $buton }}
            </button>
        </div>
    </section>
</form>
