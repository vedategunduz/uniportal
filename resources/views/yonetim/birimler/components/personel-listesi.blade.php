<form action="" method="POST">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <select name="isletme_birimleri_id" id=""
            class="bg-gray-50 border sm:col-span-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
            <option value="">Birim Seçin</option>
            @foreach ($isletmeBirimleri as $rowIsletmeBirim)
                <option value="{{ encrypt($rowIsletmeBirim->isletme_birimleri_id) }}">
                    {{ $rowIsletmeBirim->baslik }}</option>
            @endforeach
        </select>
        <button type="submit"
            class="birimePersonelAtaSubmit bg-emerald-500 text-white rounded-lg px-4 py-2.5 hover:bg-emerald-600 transition duration">Birime
            ata</button>
    </div>
    @if ($kullanicilar->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-scroll px-2 py-4 hidden-scroll">
            @foreach ($kullanicilar as $kullanici)
                @php
                    $sifreli_kullanicilar_id = encrypt($kullanici->kullanicilar_id);
                @endphp
                <div class="flex items-center gap-4">
                    <input type="checkbox" name="kullanicilar[]" value="{{ $sifreli_kullanicilar_id }}"
                        id="kullanici_{{ $sifreli_kullanicilar_id }}"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="kullanici_{{ $sifreli_kullanicilar_id }}"
                        class="inline-flex items-center gap-2 cursor-pointer select-none">
                        <span class="pointer-events-none">
                            <img src="{{ $kullanici->profilFotoUrl }}" class="size-10 rounded-full object-contain" alt="">
                        </span>
                        <span class="pointer-events-none">{{ $kullanici->ad }} {{ $kullanici->soyad }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex items-center justify-center h-24">
            <span class="text-gray-500">Kullanıcı bulunamadı.</span>
        </div>
    @endif
</form>
