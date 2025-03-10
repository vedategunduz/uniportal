@foreach ($personeller as $personel)
    @php
        $personelId = encrypt($personel->kullanicilar_id);
    @endphp
    <div class="flex items-center gap-2 border-b pb-2 last:border-none">
        <input type="checkbox" name="kullanicilar_id[]" id="checkbox_{{ $personelId }}" value="{{ $personelId }}"
            data-email="{{ $personel->email }}"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 sr-only">

        <img src="{{ $personel->profilFotoUrl }}" class="size-14 object-contain rounded-full" alt="">

        <label for="checkbox_{{ $personelId }}">
            <div class="flex flex-col">
                <span class="font-semibold">{{ $personel->ad . ' ' . $personel->soyad }}</span>
                <span class="text-xs text-gray-500">{{ $personel->telefon }}</span>
                <span class="text-xs text-gray-500">{{ $personel->email }}</span>
            </div>
        </label>
    </div>
@endforeach
