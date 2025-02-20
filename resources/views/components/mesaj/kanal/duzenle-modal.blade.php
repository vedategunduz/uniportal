@php
    $sifrelikMesajKanallari_id = encrypt($kanal->mesaj_kanallari_id);
    $yonetici = in_array(auth()->id(), $yonetici_ids) ? true : false;
@endphp

<x-modal id="modal-yeni-kanal-duzenle-{{ $sifrelikMesajKanallari_id }}" title="{!! $kanal->baslik !!}" visibility="flex"
    class="w-full sm:w-3/5 md:max-w-md lg:max-w-sm kanal-modal">

    <form action="{{ route('yonetim.mesaj.kanal.update', ['kanalId' => $kanal->mesaj_kanallari_id]) }}" class="space-y-2">
        <section id="mesaj-kanal-katilimcilar"
            class="flex flex-nowrap items-center gap-2 w-full overflow-x-auto pb-2 custom-scroll">
            @foreach ($kanal->aktifKatilimcilar as $aktifKatilimcilar)
                @if ($aktifKatilimcilar->kullanici->kullanicilar_id == auth()->user()->kullanicilar_id)
                    @continue
                @endif

                <x-mesaj.kanal.kanal-katilimci :kullanici="$aktifKatilimcilar->kullanici" :kanalid="$aktifKatilimcilar->mesaj_kanallari_id" :yonetici="$yonetici" />
            @endforeach

        </section>

        <section id="mesaj-kanal-katilimcilar"
            class="flex flex-nowrap items-center gap-2 w-full overflow-x-auto pb-2 custom-scroll"></section>

        <x-relative-input :disabled="!$yonetici" label="Kanal adı" value="{!! $kanal->baslik !!}" type="text"
            name="baslik" class="py-2" placeholder=" " />

        @if ($yonetici)
            <div class="relative">
                <x-relative-input label="Kullanıcı ara" type="text" name="mesaj-kanal-katilimci-search"
                    class="py-2" placeholder=" " />

                <section id="mesaj-kanal-katilimci-search-result"
                    class="bg-white px-4 py-2 shadow-sm rounded w-full hidden flex-col absolute top-full left-0 z-20 space-y-2 overflow-y-auto max-h-48 custom-scroll">
                </section>
            </div>
        @endif

        <div class="">
            <x-switch name="sadeceYonetici" class="peer" :disabled="!$yonetici" :checked="$kanal->sadeceYonetici">
                Sadece yöneticiler mesaj gönderebilir.
            </x-switch>
        </div>

        <div @class(['grid gap-2', 'grid-cols-2' => $yonetici])>
            @if (!$lefted)
                <x-button type="button" class="kanal-sil justify-center !bg-gray-900 !text-white"
                    data-channel-id="{{ $sifrelikMesajKanallari_id }}">
                    Kanalı sil
                </x-button>
            @else
                <x-button type="button" class="mesaj-kanal-katilimci-sil justify-center !bg-gs-red !text-white"
                    data-id="{{ encrypt(auth()->id()) }}" data-channel-id="{{ $sifrelikMesajKanallari_id }}">
                    Kanaldan çık
                </x-button>

                @if ($yonetici)
                    <x-button type="submit" data-modal="{{ 'modal-yeni-kanal-duzenle-' . $sifrelikMesajKanallari_id }}"
                        class="kanal-duzenle-submit-button !bg-yellow-400 hover:!bg-yellow-500 !text-white justify-center">
                        Kanal Düzenle
                    </x-button>
                @endif
            @endif
        </div>
    </form>

</x-modal>
