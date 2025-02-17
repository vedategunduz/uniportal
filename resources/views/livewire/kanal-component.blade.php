<div class="">
    @foreach ($kanallar as $kanal)
        <div class="border-b" data-channel-name="{{ $kanal['baslik'] }}"
            wire:key="kanal-{{ $kanal['mesaj_kanallari_id'] }}">
            <header
                class="border-l-4 border-l-transparent hover:border-l-blue-400 cursor-pointer aside-message-accordion-button"
                data-channel-id="{{ $kanal['mesaj_kanallari_id'] }}">
                <livewire:kanal-header-component :kanalId="$kanal['mesaj_kanallari_id']"
                    wire:key="kanal-header-{{ $kanal['mesaj_kanallari_id'] }}" />
            </header>
            <section class="max-h-0 transition-all overflow-hidden">
                <div class="bg-gray-50 channel">

                    <livewire:mesajlar-component :kanalId="$kanal['mesaj_kanallari_id']"
                        wire:key="mesajlar-{{ $kanal['mesaj_kanallari_id'] }}" />

                    <form action="" class="p-4 mesaj-create-form">
                        <input type="hidden" name="mesaj_kanallari_id" value="{{ $kanal['mesaj_kanallari_id'] }}" />
                        <input type="hidden" name="alintilanan_mesajlar_id" value="" alintiId />

                        <div class="alinti-gosterim hidden mb-4">
                            <div class="flex gap-2">
                                <div class="alinti-gosterim-mesaj"></div>

                                <div class="">
                                    <x-button type="button" class="alinti-iptal">İptal</x-button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-stretch">
                            <x-textarea name="mesaj" rows="1"
                                class="!bg-white rounded-r-none max-h-48 overflow-auto hidden-scroll resize-none"></x-textarea>

                            <x-button type="submit" class="mesaj-submit-button rounded-l-none border-l-0"
                                data-container="mesaj-container-{{ $kanal['mesaj_kanallari_id'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z" />
                                </svg>
                            </x-button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    @endforeach
</div>
