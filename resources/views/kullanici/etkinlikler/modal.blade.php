<section class="px-4 py-8">
    <form method="POST" id="etkinlikForm" class="grid md:grid-cols-2 gap-4">
        <section>
            <div class="mb-3">
                <select name="etkinlikIsletme" id="etkinlikIsletme"
                    class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @if ($isletmeler->count() > 1)
                        <option selected>İşletme seçin</option>
                    @endif
                    @foreach ($isletmeler as $isletme)
                        <option value="{{ encrypt($isletme->isletmeBilgileri->isletmeler_id) }}">
                            {{ $isletme->isletmeBilgileri->baslik }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 font-medium">
                <x-input id="etkinlikBaslik" type="text" name="etkinlikBaslik" placeholder="Etkinlik Adı" />
            </div>
            <div class="my-3">
                <select name="etkinlikTur" id="etkinlikTur"
                    class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option>Etkinlik Kategorisi</option>
                    @foreach ($etkinlikTurleri as $etkinlikTur)
                        <option value="{{ encrypt($etkinlikTur->etkinlik_turleri_id) }}">
                            {{ $etkinlikTur->baslik }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 grid md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <button disabled="disabled"
                        class="bg-blue-700 border font-medium border-blue-300 text-white text-xs md:text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        Etkinlik Başlangıç/Bitiş
                    </button>
                </div>
                <div class="">
                    <input type="datetime-local" name="etkinlikBaslangic" id="etkinlikBaslangic"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="">
                    <input type="datetime-local" name="etkinlikBitis" id="etkinlikBitis"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
            </div>
            <div class="mb-3 grid md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <button disabled="disabled"
                        class="bg-blue-700 border font-medium border-blue-300 text-white text-xs md:text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        Başvuru Başlangıç/Bitiş
                    </button>
                </div>
                <div class="">
                    <input type="datetime-local" name="etkinlikBasvuru" id="etkinlikBasvuru"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="">
                    <input type="datetime-local" name="etkinlikBasvuruBitis" id="etkinlikBasvuruBitis"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
            </div>
            <div class="mb-3">
                <x-label for="etkinlikAciklama" text="Açıklama" />
                <textarea id="etkinlikAciklama" name="etkinlikAciklama"></textarea>
            </div>
        </section>

        <section class="">
            <div class="mb-3">
                <label for="etkinlikKapakResmi"
                    class="h-36 border-2 border-dashed flex items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-500">Kapak resmi</span>
                </label>
                <input type="file" name="etkinlikKapakResmi" class="sr-only" id="etkinlikKapakResmi"
                    accept="image/*">
            </div>
            <div class="mb-3">
                <label for="etkinlikDigerResimler"
                    class="h-48 border-2 border-dashed flex items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-500">Diğer resimler</span>
                </label>
                <input type="file" name="etkinlikDigerResimler[]" class="sr-only" id="etkinlikDigerResimler"
                    accept="image/*">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-3">
                    <input type="number" name="etkinlikKontenjan" id="etkinlikKontenjan" min="0"
                        placeholder="Kontenjan giriniz"
                        class="bg-gray-50 font-medium border border-gray-300 text-gray-900 text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                </div>
                <div class="mb-3">
                    <select name="etkinlikIl" id="etkinlikIl"
                        class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Etkinlik Düzenlendiği İl</option>
                        @foreach ($iller as $il)
                            <option value="{{ encrypt($il->iller_id) }}">{{ $il->baslik }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="button" id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
                class="flex items-center font-medium justify-between border text-sm py-2 px-3 text-gray-900 rounded-md hover:bg-gray-50 transition w-full">
                <span>Katılım Sınırlaması <span class="text-gray-600 text-xs">(Opsiyonel)</span></span>
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar"
                class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow py-2">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-2 p-4  h-48 overflow-auto">
                    @foreach ($iller as $il)
                        @php
                            $sifreli_il_id = 'checbox_' . encrypt($il->iller_id);
                        @endphp
                        <div class="flex items-center">
                            <input id="{{ $sifreli_il_id }}" type="checkbox"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                            <label for="{{ $sifreli_il_id }}"
                                class="ms-2 text-sm font-medium text-gray-900 select-none">{{ $il->baslik }}</label>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="my-3">
                    <label class="cursor-pointer flex justify-between items-center gap-4">
                        <span class="text-sm font-medium text-gray-900">Yorum yapmayı
                            kapat</span>
                        <input type="checkbox" name="etkinlikYorumDurumu" class="sr-only peer" checked>
                        <div
                            class=" -ml-96  relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                    </label>
                    <p class="text-xs text-gray-500">Etkinliği yoruma kapatır.</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div class="">
                    <label class="cursor-pointer flex justify-between items-center gap-4">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Sosyal medyada
                            paylaş</span>
                        <input type="checkbox" name="etkinlikSosyalMedyadaPaylas" class="sr-only peer" checked>
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                    </label>
                    <p class="text-xs text-gray-500">Etkinlik
                        instagram sayfanızda yayınlanır.</p>
                </div>
            </div>


            <div class="flex items-center justify-end gap-2 mt-8 border-t pt-4">
                <button type="button" data-modal-target="etkinlikModal"
                    class="py-2 px-3 rounded-md border text-gray-900 hover:bg-gray-50 transition">Vazgeç</button>
                <button type="submit"
                    class="py-2 px-3 rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">Etkinlik
                    Oluştur</button>
            </div>
        </section>
    </form>
</section>
