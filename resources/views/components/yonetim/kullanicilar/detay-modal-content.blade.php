<header class="flex items-center justify-between bg-yellow-400 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> Personel detay </h2>
    </div>
    <button class="close-modal" data-modal="modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<form action="" class="p-6 space-y-4">
    <div class="flex gap-6">
        <section class="relative">
            <img src="{{ asset($kullanici->profilFotoUrl) }}" class="size-48 rounded" alt="">

            <button type="button" class="rounded-full bg-white shadow top-0 right-0 absolute -mt-4 -mr-4 p-2.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    class="bi bi-pencil-square size-4 pointer-events-none" viewBox="0 0 16 16">
                    <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                    <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                </svg>
            </button>
        </section>
        <section class="space-y-4">
            <input type="hidden" name="kullanicilar_id" value="{{ encrypt($kullanici->kullanicilar_id) }}">
            {{-- Personel ad ve soyad --}}
            <div class="grid grid-cols-2 gap-2">
                <div class="relative">
                    <input type="text" name="ad" id="ad"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " value="{{ $kullanici->ad }}" />
                    <label for="ad"
                        class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                        Ad
                    </label>
                </div>
                <div class="relative">
                    <input type="text" name="soyad" id="soyad"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " value="{{ $kullanici->soyad }}" />
                    <label for="soyad"
                        class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                        Soyad
                    </label>
                </div>
            </div>
            {{-- Personel e-posta --}}
            <div class="relative">
                <input type="email" name="email" id="email"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " value="{{ $kullanici->email }}" />
                <label for="email"
                    class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                    E-posta
                </label>
            </div>
            {{-- Personel telefon --}}
            <div class="relative">
                <input type="tel" name="telefon" id="telefon"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-transparent rounded border-1 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " value="{{ $kullanici->telefon }}" />
                <label for="telefon"
                    class="absolute text-sm font-medium text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                    Telefon
                </label>
            </div>
        </section>
    </div>

    <div class="space-y-4">
        @foreach ($birimDetaylari as $rowBirimDetaylari)
            <div class="flex items-center justify-between gap-2 pb-4 odd:border-b">
                <span class="text-nowrap">{{ $rowBirimDetaylari->birim->baslik }}</span>
                <select name="unvanlar_id" id="unvanlar_id"
                    data-kullanicilar-id="{{ encrypt($kullanici->kullanicilar_id) }}"
                    data-birim-id="{{ encrypt($rowBirimDetaylari->birim->isletme_birimleri_id) }}"
                    class="unvanDegistir bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block p-2.5">

                    @foreach ($unvanlar as $unvan)
                        <option value="{{ encrypt($unvan->unvanlar_id) }}"
                            @if ($rowBirimDetaylari->unvan->unvanlar_id == $unvan->unvanlar_id) selected @endif>
                            {{ $unvan->baslik }}</option>{{ $unvan->baslik }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach
    </div>

    {{-- MODAL Standart butonlar --}}
    <footer class="grid grid-cols-2 gap-2 mt-4">
        <button data-modal="modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="submit" @class([
            'updateKullaniciSubmit text-white px-3 py-2 rounded transition focus:ring-4 bg-yellow-400 hover:bg-yellow-500 ring-yellow-300',
        ])>Düzenle</button>
    </footer>
</form>
