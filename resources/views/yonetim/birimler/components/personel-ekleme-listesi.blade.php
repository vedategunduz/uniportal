@foreach ($kullanicilar as $kullanici)
    @php
        $sifreli_kullanicilar_id = encrypt($kullanici->kullanicilar_id);
    @endphp
    <div class="group border-b">
        <input type="checkbox" id="checkbox_kullanici_{{ $sifreli_kullanicilar_id }}" name="eklenecekPersoneller[]" value="{{ $sifreli_kullanicilar_id }}" class="hidden w-4 h-4">
        <label for="checkbox_kullanici_{{ $sifreli_kullanicilar_id }}" class="flex items-center gap-2 w-full cursor-pointer pb-2">
            <img src="{{ $kullanici->profilFotoUrl }}" class=" w-12 h-12 rounded-full" alt="Avatar">
            <div class="">
                <p class="select-none">{{ $kullanici->ad }} {{ $kullanici->soyad }}</p>
                <p class="text-xs text-gray-500">{{ $kullanici->email }}</p>
            </div>
        </label>
    </div>
@endforeach
