<section class="flex gap-4 pr-4 items-center mesaj-katilimci border-b py-2">
    <div class="relative flex-shrink-0">
        <img src="{{ $kullanici->profilFotoUrl }}" class="size-10 rounded-full" alt="">

        @if ($yonetici)
            <x-button
                class="mesaj-kanal-katilimci-sil absolute bottom-0 right-0 bg-white !shadow-none !p-0 !rounded-full"
                data-channel-id="{{ encrypt($kanalid) }}" data-id="{{ encrypt($kullanici->kullanicilar_id) }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x"
                    viewBox="0 0 16 16">
                    <path
                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg>
            </x-button>
        @endif
    </div>

    <div class="flex flex-col">
        <span class="text-sm font-semibold">{{ $kullanici->ad . ' ' . $kullanici->soyad }}</span>
        <span class="text-xs text-gray-500">{{ optional($kullanici->anaIsletme)->kisaltma }}</span>
    </div>

    <div class="ml-auto">
        @if ($yonetici)
            {{-- <p class="text-xs text-gray-500 mb-2"></p> --}}
            <x-switch name="yoneticilik" class="yoneticilik-degistir"
                data-channel-id="{{ encrypt($kanalid) }}" data-id="{{ encrypt($kullanici->kullanicilar_id) }}"
                :checked="$kullanici->kanalYoneticisiMi($kanalid)">
                K. Yönetici
            </x-switch>
        @else
            @if ($kullanici->kanalYoneticisiMi($kanalid))
                <span class="text-xs font-light text-emerald-700 text-nowrap bg-emerald-100 px-1.5  py-0.5 rounded border border-emerald-50">Kanal yöneticisi</span>
            @else
                <span class="text-xs font-light text-gray-900 text-nowrap">Kanal üyesi</span>
            @endif
        @endif
    </div>
</section>
