@foreach ($kullanicilar as $kullanici)
    @php
        $kullaniciId = encrypt($kullanici->kullanicilar_id);
    @endphp
    <div class="flex items-center gap-2 border-b pb-2 last:border-none">
        <input type="checkbox" name="kullanicilar_id[]" id="checkbox_{{ $kullaniciId }}" value="{{ $kullaniciId }}"
            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 sr-only">

        <img src="{{ $kullanici->profilFotoUrl }}" class="size-14 object-contain rounded-full" alt="">

        <label for="checkbox_{{ $kullaniciId }}">
            <div class="flex flex-col">
                <span class="font-semibold">{{ $kullanici->ad . ' ' . $kullanici->soyad }}</span>
                <span class="text-xs text-gray-500">{{ optional($kullanici->anaIsletme)->baslik }}
                </span>
                <span class="text-xs text-gray-500">{{ $kullanici->email }}</span>
            </div>
        </label>

        <x-button class="mesaj-kanal-katilimci-ekle text-sm ml-auto !py-1.5" data-email="{{ $kullanici->email }}">
            Ekle
        </x-button>
    </div>
@endforeach

@if ($kullanicilar->count() == 0)
    <div class="flex items-center justify-center py-4">
        <span class="text-gray-500 text-sm">Kullanıcı bulunamadı.</span>
    </div>
@endif
