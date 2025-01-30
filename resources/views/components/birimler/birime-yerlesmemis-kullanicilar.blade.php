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
                        <img src="{{ $kullanici->profilFotoUrl }}" class="size-10 rounded-full object-contain"
                            alt="">
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
