<div class="">
    @foreach ($kanallar as $kanal)
        <div class="border-b" data-channel-name="{{ $kanal['baslik'] . ($kanal['etkinlik']['kod'] ?? '') }}"
            wire:key="kanal-{{ $kanal['mesaj_kanallari_id'] }}">

            <header class="flex items-center justify-between pr-6">
                <div @class([
                    'w-full border-l-4 border-l-transparent hover:border-l-blue-400 cursor-pointer aside-message-accordion-button',
                ]) data-channel-id="{{ $kanal['mesaj_kanallari_id'] }}" wire:ignore.self>

                    <livewire:kanal-header-component :kanalId="$kanal['mesaj_kanallari_id']"
                        wire:key="kanal-header-{{ encrypt($kanal['mesaj_kanallari_id']) }}" />
                </div>
                <x-button
                    class="kanal-duzenle
                        border-none !shadow-none !bg-white !text-gray-300 hover:!text-gray-700"
                    data-channel-id="{{ $kanal['mesaj_kanallari_id'] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-gear-fill size-4" viewBox="0 0 16 16">
                        <path
                            d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                    </svg>
                </x-button>
            </header>

            <section class="max-h-0 transition-all overflow-hidden" wire:ignore.self>
                <div class="bg-gray-50 channel">

                    <livewire:mesajlar-component :kanalId="$kanal['mesaj_kanallari_id']"
                        wire:key="mesajlar-{{ $kanal['mesaj_kanallari_id'] }}" />

                    <form action="" class="p-4 mesaj-create-form">
                        <input type="hidden" name="mesaj_kanallari_id" value="{{ $kanal['mesaj_kanallari_id'] }}" />
                        <input type="hidden" name="alintilanan_mesajlar_id" value="" alintiId />
                        <input type="hidden" name="yd" value="{{ encrypt($kanal['sadeceYonetici']) }}" />

                        <div class="alinti-gosterim hidden mb-4">
                            <div class="flex gap-2">
                                <div class="alinti-gosterim-mesaj"></div>

                                <div class="">
                                    <x-button type="button" class="alinti-iptal">İptal</x-button>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between px-4 py-2">
                            <span>dwqdwqdqwdq.docx</span>
                            <x-button class="!shadow-none !bg-transparent !border-none">
                                <i class="bi bi-x text-base"></i>
                            </x-button>
                        </div>

                        <div class="flex items-stretch" data-mesaj-gonderme-wrapper>
                            <div data-mesaj-dosya-yukleme-wrapper>
                                <x-button class="rounded-r-none border-r-0 mesaj-dosya-yukleme-button">
                                    <i class="bi bi-paperclip text-base"></i>
                                </x-button>
                                <input type="file" name="file" class="hidden" data-mesaj-dosya-yukleme-input />
                            </div>

                            <x-textarea name="mesaj" rows="1" data-mesaj-textarea
                                class="!bg-white rounded-none max-h-48 overflow-auto hidden-scroll resize-none"></x-textarea>

                            <x-button type="submit"
                                class="!text-gray-900 mesaj-submit-button rounded-l-none border-l-0"
                                data-container="mesaj-container-{{ $kanal['mesaj_kanallari_id'] }}">
                                <i class="bi bi-send-fill text-base"></i>
                            </x-button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    @endforeach
</div>
