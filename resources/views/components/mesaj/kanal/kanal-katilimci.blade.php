<div class="relative flex-shrink-0 mesaj-katilimci">
    <img src="{{ $kullanici->profilFotoUrl }}" class="size-12 rounded-full" alt="">

    @if ($yonetici)
        <x-button class="mesaj-kanal-katilimci-sil absolute bottom-0 right-0 bg-white !shadow-none !p-0 !rounded-full"
            data-channel-id="{{ encrypt($kanalid) }}" data-id="{{ encrypt($kullanici->kullanicilar_id) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x"
                viewBox="0 0 16 16">
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </x-button>
    @endif
</div>
