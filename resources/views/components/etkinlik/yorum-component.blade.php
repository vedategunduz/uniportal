@props(['yorum', 'depth' => 0])

<section data-yorum-wrapper>
    <div class="flex items-start gap-2 px-4 py-2">
        <img src="{{ $yorum->kullanici->profilFotoUrl }}" class="size-10 rounded-full shrink-0" alt="Yorum Yapan">

        <div class="text-sm w-full">
            <header class="font-medium text-gray-800">
                {{ $yorum->kullanici->ad . ' ' . $yorum->kullanici->soyad }}
                ({{ $yorum->kullanici->anaIsletme->kisaltma }})

                <x-uniportal-dropdown class="!shadow-none !border-none !p-1" alignment="right">
                    <x-slot name="trigger">
                        <i class="bi bi-three-dots-vertical"></i>
                    </x-slot>

                    <x-slot name="target">
                        <x-uniportal-dropdown-item href="javascript:void(0)" class="etkinlik-yorum-şikayet-et"
                            data-id="{{ encrypt($yorum->etkinlik_yorumlari_id) }}">
                            <i class="bi bi-exclamation-triangle-fill text-base text-orange-500"></i>
                            <span class="ms-2">Şikayet et</span>
                        </x-uniportal-dropdown-item>
                        @if ($yorum->kullanicilar_id == auth()->id())
                            <x-uniportal-dropdown-item href="javascript:void(0)" class="etkinlik-yorum-sil"
                                data-etkinlik-id="{{ encrypt($yorum->etkinlikler_id) }}"
                                data-yorum-id="{{ encrypt($yorum->etkinlik_yorumlari_id) }}">
                                <i class="bi bi-x-circle-fill text-base text-gs-red-2"></i>
                                <span class="ms-2">Sil</span>
                            </x-uniportal-dropdown-item>
                        @endif
                    </x-slot>
                </x-uniportal-dropdown>
            </header>

            <section class="flex items-center justify-between gap-2">
                <div class="text-gray-600 show-more-text text-ellipsis line-clamp-3 w-full">{!! $yorum->yorum !!}
                </div>

                <x-button class="!shadow-none !border-0 !p-0 !bg-transparent !text-base etkinlik-yorum-begen"
                    data-yorum-id="{{ encrypt($yorum->etkinlik_yorumlari_id) }}"
                    data-etkinlik-id="{{ encrypt($yorum->etkinlikler_id) }}" :disabled="!auth()->check()">
                    @if ($yorum->begeni->contains('kullanicilar_id', auth()->id()))
                        <i class="bi bi-heart-fill text-rose-500"></i>
                    @else
                        <i class="bi bi-heart"></i>
                    @endif
                </x-button>
            </section>

            <footer class="flex items-center gap-2 mt-1">
                <p class="font-semibold text-xs text-gray-500">
                    {{ $yorum->created_at->diffForHumans() }}
                </p>
                {{-- @if ($yorum->begeni->count()) --}}
                <p data-yorum-begeni-wrapper @class([
                    'font-semibold text-xs text-gray-500 flex items-center gap-2',
                    'hidden' => !$yorum->begeni->count(),
                ])>
                    <i class="bi bi-heart-fill"></i>
                    <span data-yorum-begeni-count>{{ $yorum->begeni->count() }}</span>
                </p>
                {{-- @endif --}}
                @if ($yorum->yanit->count())
                    <x-button
                        class="!shadow-none !border-0 !px-2 !py-0 !text-gray-500 !bg-transparent etkinlik-yorum-yanit-goster">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-chat-left-text-fill"></i>
                            <span>{{ $yorum->yanit->count() }}</span>
                        </div>
                    </x-button>
                @endif
                <x-button
                    class="!shadow-none !border-0 !p-0 !text-blue-500 hover:!underline !bg-transparent capitalize etkinlik-yorum-yanitla-button"
                    data-yorum-id="{{ encrypt($yorum->etkinlik_yorumlari_id) }}"
                    data-sender="{{ $yorum->kullanici->ad . ' ' . $yorum->kullanici->soyad }}" :disabled="!auth()->check()">
                    Yanıtla
                </x-button>
            </footer>
        </div>
    </div>
    @if ($yorum->yanit->count())
        <!-- Sadece depth 0 için girinti ekle -->
        <div data-yorum-yanit-wrapper wire:ignore.self @class(['pt-2 hidden', 'pl-12' => $depth < 3])>
            <x-etkinlik.yorumlar-component :yorumlar="$yorum->yanit" :depth="$depth + 1" />
        </div>
    @endif
</section>
