<header class="flex justify-between rounded-t-md items-center p-4 border-b bg-blue-700 text-white">
    <h2 class="font-medium text-lg">{{ $modalBaslik }}</h2>

    <button type="button" class="close-modal" data-modal-target="etkinlikModal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<section class="px-4 py-8">
    <form action="{{ $postUrl }}" method="POST" id="etkinlikForm" class="grid md:grid-cols-3 gap-24">
        <section class="md:col-span-2">
            <div class="mb-3">
                <select name="etkinlikIsletme" id="etkinlikIsletme"
                    class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    @if ($isletmeler->count() > 1)
                        <option value="">İşletme seçin</option>
                    @endif
                    @foreach ($isletmeler as $rowIsletme)
                        <option value="{{ encrypt($rowIsletme->isletmeler_id) }}"
                            @if ($isletme == $rowIsletme->isletmeler_id) selected @endif>
                            {{ $rowIsletme->isletmeBilgileri->baslik }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 font-medium">
                <x-input id="etkinlikBaslik" type="text" name="etkinlikBaslik" placeholder="Etkinlik Adı"
                    value="{{ $etkinlikBaslik }}" />
            </div>
            <div class="my-3">
                <select name="etkinlikTur" id="etkinlikTur"
                    class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Etkinlik Kategorisi</option>
                    @foreach ($etkinlikTurleri as $etkinlikTur)
                        <option value="{{ encrypt($etkinlikTur->etkinlik_turleri_id) }}"
                            @if ($kategori == $etkinlikTur->etkinlik_turleri_id) selected @endif>
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
                        value="{{ $baslamaTarih }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="">
                    <input type="datetime-local" name="etkinlikBitis" id="etkinlikBitis" value="{{ $bitisTarih }}"
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
                    <input type="datetime-local" name="etkinlikBasvuru" id="etkinlikBasvuru" value="{{ $basvuruTarih }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
                <div class="">
                    <input type="datetime-local" name="etkinlikBasvuruBitis" id="etkinlikBasvuruBitis"
                        value="{{ $basvuruBitisTarih }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
            </div>
            <div class="mb-3">
                <x-label for="etkinlikAciklama" text="Açıklama" />
                <textarea id="etkinlikAciklama" name="etkinlikAciklama">{{ $aciklama }}</textarea>
            </div>
        </section>

        <section class="">
            <div class="mb-3">
                <label for="etkinlikKapakResmi"
                    class="relative min-h-32 border-2 border-dashed flex items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-500 absolute top-2 left-2 z-50">Kapak resmi</span>
                    <div id="resimcontainer">
                        @if ($kapakResim)
                            <img src="{{ asset('storage/' . $kapakResim) }}" alt="Kapak Resmi" class="size-24">
                        @endif
                    </div>
                </label>
                <input type="file" name="etkinlikKapakResmi" class="sr-only" id="etkinlikKapakResmi"
                    accept="image/*">
            </div>
            <div class="mb-3">
                <label for="etkinlikDigerResimler"
                    class="relative min-h-32 overflow-auto border-2 border-dashed flex items-center justify-center cursor-pointer hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-500 absolute top-2 left-2 z-50">Galeri</span>
                    <div id="resimlercontainer" class="w-96 flex gap-4 overflow-y-auto">
                        @if ($digerResimler)
                            @foreach ($digerResimler as $resim)
                                <div class="relative">
                                    <button type="button"
                                        class="absolute right-0 top-0 p-1 bg-rose-500 text-white size digerResimSilButton"
                                        data-target="">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="size-4 pointer-events-none">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <img src="{{ asset('storage/' . $resim) }}" alt="Diğer Resimler"
                                        class="size-24">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </label>
                <input type="file" name="etkinlikDigerResimler[]" multiple class="sr-only"
                    id="etkinlikDigerResimler" accept="image/*">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-3">
                    <input type="number" name="etkinlikKontenjan" id="etkinlikKontenjan" min="0"
                        placeholder="Kontenjan giriniz" value="{{ $kontenjan }}"
                        class="bg-gray-50 font-medium border border-gray-300 text-gray-900 text-sm rounded-lg w-full focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                </div>
                <div class="mb-3">
                    <select name="etkinlikIl" id="etkinlikIl"
                        class="bg-gray-50 border font-medium border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Etkinlik Düzenlendiği İl</option>
                        @foreach ($iller as $il)
                            <option value="{{ encrypt($il->iller_id) }}"
                                @if ($il->iller_id == $sehir) selected @endif>{{ $il->baslik }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <button type="button"
                    class="dropdown-btn flex items-center font-medium justify-between border text-sm py-2 px-3 text-gray-900 rounded-md hover:bg-gray-50 transition w-full">
                    <span class="pointer-events-none">Katılım sınırlaması <span class="text-gray-600 text-xs"
                            id="katilimSinirlamaText">(Opsiyonel)</span></span>
                    <svg class="w-2.5 h-2.5 ms-2.5 pointer-events-none" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <div class="hidden max-w-screen-sm border rounded-md absolute bg-white z-50">
                    <div class="grid p-4 grid-cols-3 h-48 overflow-auto" id="katilimSinirlamaContainer">
                        @foreach ($iller as $il)
                            @php
                                $sifreli_il_id = 'checbox_' . encrypt($il->iller_id);
                            @endphp
                            <div class="flex items-center">
                                <input id="{{ $sifreli_il_id }}" name="katilimSinirlama[]" type="checkbox"
                                    value="{{ encrypt($il->iller_id) }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                    @if (in_array($il->iller_id, $katilimSinirlama)) checked @endif>
                                <label for="{{ $sifreli_il_id }}"
                                    class="ms-2 text-sm font-medium text-gray-900 select-none">{{ $il->baslik }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="">
                <div class="my-3">
                    <label class="cursor-pointer flex justify-between items-center gap-4">
                        <span class="text-sm font-medium text-gray-900">Yorum yapmayı
                            kapat</span>
                        <input type="checkbox" name="etkinlikYorumDurumu" class="sr-only peer"
                            @if ($yorumDurumu) checked @endif>
                        <div
                            class=" -ml-96  relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                    </label>
                    <p class="text-xs text-gray-500">Etkinliği yoruma kapatır.</p>
                </div>
            </div>

            <div class="">
                <div class="">
                    <label class="cursor-pointer flex justify-between items-center gap-4">
                        <span class="text-sm font-medium text-gray-900 dark:text-gray-300">Sosyal medyada
                            paylaş</span>
                        <input type="checkbox" name="etkinlikSosyalMedyadaPaylas" class="sr-only peer"
                            @if ($sosyalMedyaDurum) checked @endif>
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                        </div>
                    </label>
                    <p class="text-xs text-gray-500">Etkinlik
                        instagram sayfamızda yayınlanır.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-8 border-t pt-4">
                <button type="button" data-modal-target="etkinlikModal"
                    class="close-modal w-full py-2 px-3 rounded-md border text-gray-900 hover:bg-gray-50 transition">Vazgeç</button>
                <button type="submit"
                    class="py-2 px-3 w-full rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">{{ $modalSubmitText }}</button>
            </div>
        </section>
    </form>
</section>
