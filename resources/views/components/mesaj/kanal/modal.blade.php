@php
    $sifrelikMesajKanallari_id = encrypt($kanal->mesaj_kanallari_id);
@endphp

<x-modal id="modal-yeni-kanal-duzenle-{{ $sifrelikMesajKanallari_id }}" title="{{ $kanal->baslik }} Düzenle" visibility="flex"
    class="w-full sm:w-3/5 md:max-w-md lg:max-w-sm">

    <form action="" class="space-y-2">
        <section id="mesaj-kanal-katilimcilar"
            class="flex flex-nowrap items-center gap-2 w-full overflow-x-auto pb-2 custom-scroll"></section>

        <x-relative-input label="{{ $kanal->baslik }}" type="text" name="baslik" class="py-2" placeholder=" " />

        <div class="relative">
            <x-relative-input label="Kullanıcı ara" type="text" name="mesaj-kanal-katilimci-search" class="py-2"
                placeholder=" " />

            <section id="mesaj-kanal-katilimci-search-result"
                class="bg-white px-4 py-2 shadow-sm rounded w-full hidden flex-col absolute top-full left-0 z-20 space-y-2 overflow-y-auto max-h-48 custom-scroll">
            </section>
        </div>

        <div class="">
            <x-switch name="sadeceYonetici" class="peer" :checked="$kanal->sadeceYonetici">
                Sadece yöneticiler mesaj gönderebilir.
            </x-switch>
        </div>

        <x-button type="submit" id="kanal-olustur-submit-button" class="bg-yellow-500 hover:bg-yellow-600">
            Kanal Düzenle
        </x-button>
    </form>

</x-modal>
