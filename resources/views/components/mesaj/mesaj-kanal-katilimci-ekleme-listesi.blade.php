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

        <x-button class="mesaj-kanal-katilimci-ekle text-sm ml-auto !py-1.5 !bg-emerald-500 !text-white" data-email="{{ $kullanici->email }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                <path fill-rule="evenodd"
                    d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
            </svg>
        </x-button>
    </div>
@endforeach

@if ($kullanicilar->count() == 0)
    <div class="flex items-center justify-center py-4">
        <span class="text-gray-500 text-sm">Kullanıcı bulunamadı.</span>
    </div>
@endif
