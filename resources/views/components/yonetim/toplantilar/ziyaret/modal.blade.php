<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> Ziyaret Oluştur </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="">
    <section class="flex flex-col gap-4 p-4" style="height: 80vh;">
        {{-- INPUT Etkinlik başlığı --}}
        <div class="relative">
            <input type="text" name="baslik" id="baslik"
                class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder=" " />
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
                <input type="datetime-local" name="etkinlikBaslamaTarihi" value=""
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            {{-- INPUT Etkinlik başvuru bitiş tarihi --}}
            <div class="">
                <input type="datetime-local" name="etkinlikBitisTarihi" value=""
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
        </div>

        <div class="">
            <textarea id="aciklama" rows="4"
                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Ziyaret bilgisi..."></textarea>
        </div>

        <div class="grid lg:grid-cols-2 mb-4 gap-4 ">
            <div class="space-y-4">
                <h5>Ziyaret Eden Kurum</h5>
                <select name="olusturan_isletmeler_id" id="olusturan_isletmeler_id" @class([
                    'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5',
                ])>
                    @foreach ($isletmeler as $isletme)
                        <option value="{{ encrypt($isletme->isletmeler_id) }}">{{ $isletme->baslik }}</option>
                    @endforeach
                </select>
                <input type="text" name="search" id="search" placeholder="Ara..."
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                <div class="relative">
                    <div id="gidecekPersoneller"
                        class="max-h-80 space-y-4 overflow-y-auto px-4 absolute top-0 left-0 bg-white z-20 w-full shadow rounded">
                    </div>
                </div>

                <div id="selectedPersonel" class="space-y-2 pb-12 max-h-80 overflow-y-auto">
                    <h2 class="font-medium text-lg border-b mb-4">Ziyaret Ekibi</h2>
                </div>
            </div>
            <div class="space-y-4">
                <h5>Kabul Eden Kurum</h5>
                <select name="gidilen_isletmeler_id" id="gidilen_isletmeler_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Kurum seçiniz...</option>
                    @foreach ($tumIsletmeler as $tumIsletme)
                        <option value="{{ encrypt($tumIsletme->isletmeler_id) }}">{{ $tumIsletme->baslik }}</option>
                    @endforeach
                </select>
                <input type="text" name="otherSearch" id="otherSearch" placeholder="Kurum seçiniz" disabled
                    class="disabled:bg-gray-200 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">

                <div class="relative">
                    <div id="gidilecekPersoneller"
                        class="max-h-80 space-y-4 overflow-y-auto px-4 absolute top-0 left-0 bg-white z-20 w-full shadow rounded">
                    </div>
                </div>

                <div id="selectedGidilecekPersonel" class="space-y-2 pb-12 max-h-80 overflow-y-auto">
                    <h2 class="font-medium text-lg border-b mb-4">Kurum Ekibi</h2>
                </div>
            </div>
        </div>

        <div class="mt-auto pb-4">
            <button type="submit"
                class="w-full bg-blue-700 text-white text-sm rounded px-4 py-2.5 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2">
                Ziyaret Oluştur
            </button>
        </div>
    </section>
</form>
