@php
    $form_baslik = 'Yeni Etkinlik Oluştur';
    $form_submit = 'Oluştur';

    $baslik = '';
    $isletmeler_id = 0;
    $etkinlik_turleri_id = 0;
    $iller_id = 0;
    $kontenjan = 500;
    $etkinlikBasvuruTarihi = '';
    $etkinlikBasvuruBitisTarihi = '';
    $etkinlikBaslamaTarihi = '';
    $etkinlikBitisTarihi = '';
    $aciklama = '';
    $yorumDurumu = 0;
    $sosyalMedyadaPaylas = 0;
    $kapakResmiYolu = '';

    if (!empty($etkinlik)) {
        $form_baslik = 'Etkinlik Düzenle';
        $form_submit = 'Güncelle';

        $baslik = $etkinlik->baslik;
        $isletmeler_id = $etkinlik->isletmeler_id;
        $etkinlik_turleri_id = $etkinlik->etkinlik_turleri_id;
        $iller_id = $etkinlik->iller_id;
        $kontenjan = $etkinlik->kontenjan;
        $etkinlikBasvuruTarihi = $etkinlik->etkinlikBasvuruTarihi;
        $etkinlikBasvuruBitisTarihi = $etkinlik->etkinlikBasvuruBitisTarihi;
        $etkinlikBaslamaTarihi = $etkinlik->etkinlikBaslamaTarihi;
        $etkinlikBitisTarihi = $etkinlik->etkinlikBitisTarihi;
        $aciklama = $etkinlik->aciklama;
        $yorumDurumu = $etkinlik->yorumDurumu;
        $sosyalMedyadaPaylas = $etkinlik->sosyalMedyadaPaylas;
        $kapakResmiYolu = $etkinlik->kapakResmiYolu;
    }
@endphp

<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> {{ $form_baslik }} </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="" enctype="multipart/form-data">
    <section class="p-6 space-y-3">
        {{-- ETKİNLİK ID --}}
        @if (!empty($etkinlik))
            <input type="hidden" name="etkinlik_id" value="{{ encrypt($etkinlik->etkinlik_id) }}">
        @endif
        {{-- SELECT İşletmeler --}}
        <div class="">
            <select name="isletmeler_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                @if ($isletmeler->count() > 1)
                    <option value="">İşletme Seçiniz</option>
                @endif
                @foreach ($isletmeler as $rowIsletmeler)
                    <option value="{{ encrypt($rowIsletmeler->isletmeler_id) }}"
                        @if ($isletmeler_id == $rowIsletmeler->isletmeler_id) selected @endif>
                        {{ $rowIsletmeler->baslik }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- INPUT Etkinlik başlığı --}}
        <div class="relative">
            <input type="text" name="baslik" id="baslik"
                class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " value="{{ $baslik }}" />
            <label for="baslik"
                class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                Etkinlik Başlığı
            </label>
        </div>
        {{-- GRID TÜR - İL --}}
        <div class="grid grid-cols-3 gap-4">
            {{-- SELECT Etkinlik türleri --}}
            <div class="">
                <select name="etkinlik_turleri_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Etkinlik Türü Seçiniz</option>
                    @foreach ($etkinlikTurleri as $rowEtkinlikTurleri)
                        <option value="{{ encrypt($rowEtkinlikTurleri->etkinlik_turleri_id) }}"
                            @if ($etkinlik_turleri_id == $rowEtkinlikTurleri->etkinlik_turleri_id) selected @endif>
                            {{ $rowEtkinlikTurleri->baslik }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- SELECT İller --}}
            <div class="">
                <select name="iller_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Etkinliğin düzenlendiği il</option>
                    @foreach ($iller as $il)
                        <option value="{{ encrypt($il->iller_id) }}" @if ($iller_id == $il->iller_id) selected @endif>
                            {{ $il->baslik }}</option>
                    @endforeach
                </select>
            </div>
            {{-- INPUT NUMBER Etkinlik kontenjan --}}
            <div class="relative">
                <input type="number" id="kontenjan" name="kontenjan" min="0"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " value="{{ $kontenjan }}" />
                <label for="kontenjan"
                    class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                    Etkinlik kontenjanı
                </label>
            </div>
        </div>
        {{-- Etkinlik başvuru başlangıç ve bitiş tarihleri --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                class="bg-blue-700 font-medium text-white text-sm rounded flex items-center justify-center col-span-2 lg:col-span-1 p-2.5">
                <span>Etkinlik Başvuru Başlangıç/Bitiş</span>
            </div>
            {{-- INPUT Etkinlik başvuru başlangıç tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBasvuruTarihi" value="{{ $etkinlikBasvuruTarihi }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            {{-- INPUT Etkinlik başvuru bitiş tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBasvuruBitisTarihi"
                    value="{{ $etkinlikBasvuruBitisTarihi }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
        </div>
        {{-- Etkinlik başlangıç ve bitiş tarihleri --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                class="bg-blue-700 font-medium text-white text-sm rounded flex items-center justify-center col-span-2 lg:col-span-1 p-2.5">
                <span>Etkinlik Başlangıç/Bitiş</span>
            </div>
            {{-- INPUT Etkinlik başlangıç tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBaslamaTarihi" value="{{ $etkinlikBaslamaTarihi }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            {{-- INPUT Etkinlik bitiş tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBitisTarihi" value="{{ $etkinlikBitisTarihi }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
        </div>
        {{-- SUMMERNOTE --}}
        <div class="">
            <label for="summernote" class="font-normal">Etkinlik açıklaması</label>
            <textarea name="aciklama" id="summernote" placeholder="etkinlik">{{ $aciklama }}</textarea>
        </div>
        {{-- INPUT FILE Etkinlik kapak resmi --}}
        {{-- GİZLİ --}}
        <input type="file" class="sr-only" name="kapakResmiYolu" id="kapakResmiYolu" accept="image/*" />
        <div @class([
            'hidden' => !empty($kapakResmiYolu),
        ]) id="kapakResmiEklemeContainer">
            <label for="kapakResmiYolu"
                class="border border-dashed flex flex-col items-center justify-center gap-4 py-10 cursor-pointer">
                <p class="font-normal text-sm text-gray-700 mb-0">Kapak fotoğrafınızı buraya sürükleyin veya <span
                        class="text-blue-500 hover:underline cursor-pointer">Cihazdan göz atın</span></p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </label>
        </div>
        {{-- INPUT FILE ile seçilen resim --}}
        <div id="kapakResmiContainer">
            @if (!empty($kapakResmiYolu))
                <div class="flex items-center justify-center border border-dashed mb-2 py-2">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $kapakResmiYolu) }}"
                            class="h-36 object-cover rounded">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                            <label for="kapakResmiYolu" class="ml-auto text-sm hover:underline text-nowrap bg-gray-50 text-gray-900 font-normal px-1.5 py-1">
                                Resmi değiştir
                            </label>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        {{-- INPUT FILE Etkinlik galeri --}}
        <div class="">
            {{-- GİZLİ --}}
            <input type="file" class="sr-only" name="resimYolu[]" id="resimYolu" accept="image/*" multiple />

            <label for="resimYolu"
                class="border border-dashed flex flex-col items-center justify-center gap-4 h-36 cursor-pointer">
                <p class="font-normal text-sm text-gray-700 mb-0">Diğer fotoğraflarınızı buraya sürükleyin veya <span
                        class="text-blue-500 hover:underline cursor-pointer">Cihazdan göz atın</span></p>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
            </label>
        </div>
        <div id="resimYoluContainer"></div>
        {{-- INPUT CHECKBOX Etkinlik yorum durumu --}}
        <div class="">
            <div class="flex items-center">
                <input type="checkbox" name="yorumDurumu" id="yorumDurumu"
                    @if ($yorumDurumu) checked @endif
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="yorumDurumu" class="ms-2 text-sm font-medium text-gray-900">Yoruma kapat</label>

            </div>
            <p class="text-sm text-gray-700">Etkinliği yoruma kapatmak için seçiniz.</p>
        </div>
        {{-- INPUT CHECKBOX Etkinlik sosyal medyada paylaş --}}
        <div class="">
            <div class="flex items-center">
                <input type="checkbox" name="sosyalMedyadaPaylas" id="sosyalMedyadaPaylas"
                    @if ($sosyalMedyadaPaylas) checked @endif
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="sosyalMedyadaPaylas" class="ms-2 text-sm font-medium text-gray-900">
                    Sosyal medyamızda paylaş
                </label>
            </div>
            <p class="text-sm text-gray-700">Etkinliğin sosyal medya hesabımızda paylaşılması için seçiniz.</p>
        </div>
    </section>
    {{-- MODAL Standart butonlar --}}
    <footer class="grid grid-cols-2 gap-2 p-6">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="submit" data-event-type="@if (empty($etkinlik)) insert @else update @endif"
            @class([
                'etkinlikSubmit text-white px-3 py-2 rounded transition focus:ring-4 disabled:bg-black',
                'bg-blue-700 hover:bg-blue-800 ring-blue-300' => empty($etkinlik),
                'bg-yellow-400 hover:bg-yellow-500 ring-yellow-300' => !empty($etkinlik),
            ])>{{ $form_submit }}</button>
    </footer>
</form>
