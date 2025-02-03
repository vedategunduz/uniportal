@foreach ($personeller as $personel)
    @php
        $personelId = encrypt($personel->kullanici_birim_unvan_iliskileri_id);;
    @endphp
    <div class="flex items-center gap-2 border-b pb-2 last:border-none">
        <input type="checkbox" name="kullanicilar_id[]" id="checkbox_{{ $personelId }}" value="{{ $personelId }}"
            data-email="{{ $personel->IzinliKullanici->email }}"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 sr-only">

        <img src="{{ $personel->IzinliKullanici->profilFotoUrl }}" class="size-14 object-contain rounded-full"
            alt="">
        <label for="checkbox_{{ $personelId }}">
            <div class="flex flex-col">
                <span class="font-medium text-sm">
                    {{ $personel->birim->baslik }}
                </span>
                <span class="font-medium text-sm">
                    {{ $personel->unvan->baslik }}
                </span>
                <span class="text-xs text-gray-500">{{ $personel->IzinliKullanici->ad . ' ' . $personel->IzinliKullanici->soyad }}</span>
                <span class="text-xs text-gray-500">{{ $personel->IzinliKullanici->telefon }}</span>
                <span class="text-xs text-gray-500">{{ $personel->IzinliKullanici->email }}</span>
            </div>
        </label>
    </div>
@endforeach
