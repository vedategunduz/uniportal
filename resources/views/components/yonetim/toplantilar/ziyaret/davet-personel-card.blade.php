<div class="flex items-center gap-2">
    <input type="hidden" name="davet_kullanicilar_id[]"
        value="{{ encrypt($personel->IzinliKullanici->kullanicilar_id) }}">

    <img src="{{ $personel->IzinliKullanici->profilFotoUrl }}" class="size-14 object-contain rounded-full" alt="">

    <div class="flex flex-col">
        <span class="font-medium text-sm">{{ $personel->birim->baslik }}</span>
        <span class="font-medium text-sm">{{ $personel->unvan->baslik }}</span>
        <span class="text-xs text-gray-500">
            {{ $personel->IzinliKullanici->ad . ' ' . $personel->IzinliKullanici->soyad }}
        </span>
        <span class="text-xs text-gray-500">{{ $personel->IzinliKullanici->telefon }}</span>
        <span class="text-xs text-gray-500">{{ $personel->IzinliKullanici->email }}</span>
    </div>

    <button type="button" class="ml-auto removeSelectedDavetPersonelEmail"
        data-email="{{ $personel->IzinliKullanici->email }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x size-6"
            viewBox="0 0 16 16">
            <path
                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
        </svg>
    </button>
</div>
