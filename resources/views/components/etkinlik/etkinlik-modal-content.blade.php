<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white">Yeni Etkinlik Oluştur</h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="">
    <section class="p-6 space-y-3">
        {{-- SELECT İşletmeler --}}
        <div class="">
            <select name="isletmeler_id" id="isletmeler_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option value="">İşletme Seçiniz</option>
                @foreach ($isletmeler as $rowIsletmeler)
                    <option value="{{ encrypt($rowIsletmeler->isletmeler_id) }}">
                        {{ $rowIsletmeler->baslik }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- INPUT Etkinlik başlığı --}}
        <div class="relative">
            <input type="text" id="baslik"
                class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " />
            <label for="baslik"
                class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                Etkinlik Başlığı
            </label>
        </div>
        {{-- SELECT Etkinlik türleri --}}
        <div class="grid grid-cols-2 gap-4">
            {{-- SELECT Etkinlik türleri --}}
            <div class="">
                <select name="etkinlik_turleri_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Etkinlik Türü Seçiniz</option>
                    @foreach ($etkinlikTurleri as $rowEtkinlikTurleri)
                        <option value="{{ encrypt($rowEtkinlikTurleri->etkinlik_turleri_id) }}">
                            {{ $rowEtkinlikTurleri->baslik }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- SELECT İller --}}
            <div class="">
                <select name="isletmeler_id" id="isletmeler_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Etkinliğin düzenlendiği il</option>
                    @foreach ($iller as $il)
                        <option value="{{ encrypt($il->iller_id) }}">
                            {{ $il->baslik }}</option>
                    @endforeach
                </select>
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
                <input type="datetime-local" name="etkinlikBaslamaTarihi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            {{-- INPUT Etkinlik bitiş tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBitisTarihi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
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
                <input type="datetime-local" name="etkinlikBasvuruTarihi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            {{-- INPUT Etkinlik başvuru bitiş tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBasvuruBitisTarihi"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
        </div>
        {{-- SUMMERNOTE --}}
        <div class="">
            <label for="summernote">Etkinlik açıklaması</label>
            <textarea name="aciklama" id="summernote"></textarea>
        </div>
        {{-- INPUT NUMBER Etkinlik kontenjan --}}
        <div class="relative">
            <input type="number" id="kontenjan" name="kontenjan" min="0"
                class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " />
            <label for="kontenjan"
                class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1">
                Etkinlik kontenjanı
            </label>
        </div>
        {{-- INPUT CHECKBOX Etkinlik yorum durumu --}}
        <div class="">
            <div class="flex items-center">
                <input type="checkbox" name="yorumDurumu" id="yorumDurumu" value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="yorumDurumu" class="ms-2 text-sm font-medium text-gray-900">Yoruma kapat</label>

            </div>
            <p class="text-sm">Etkinliği yoruma kapatmak için seçiniz.</p>
        </div>
        {{-- INPUT CHECKBOX Etkinlik sosyal medyada paylaş --}}
        <div class="">
            <div class="flex items-center">
                <input type="checkbox" name="sosyalMedyadaPaylas" id="sosyalMedyadaPaylas" checked value=""
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                <label for="sosyalMedyadaPaylas" class="ms-2 text-sm font-medium text-gray-900">Sosyal medyamızda
                    paylaş</label>

            </div>
            <p class="text-sm">Etkinliğin sosyal medya hesabımızda paylaşılması için seçiniz.</p>
        </div>
        {{-- INPUT FILE Etkinlik kapak resmi --}}
        <div class="">
            <input type="file" name="kapakResmiYolu" accept="image/*" />
        </div>
        {{-- INPUT FILE Etkinlik galeri --}}
        <div class="">
            <input type="file" name="resimYolu[]" accept="image/*" multiple />
        </div>
    </section>
    {{-- MODAL Standart butonlar --}}
    <footer class="grid grid-cols-2 gap-2 p-6">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="submit" class="bg-blue-700 text-white px-3 py-2 rounded transition">Oluştur</button>
    </footer>
</form>
