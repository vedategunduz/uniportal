@php
    use Carbon\Carbon;
@endphp
<section class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach ($paylasimlar as $paylasim)
        <div class="flex flex-col shadow border rounded text-gray-700 bg-white"
            wire:key="paylasim-{{ encrypt($paylasim->paylasimlar_id) }}">
            <header class="border-b py-1.5 px-4 flex justify-between items-center rounded-t">
                <a href="{{ route('yonetim.kullanici.show', encrypt($kullanici->kullanicilar_id)) }}"
                    class="flex items-center gap-2">
                    <img src="{{ $kullanici->profilFotoUrl }}" class="size-8 rounded-full object-contain" loading="lazy"
                        alt="">

                    <span class="text-xs font-medium ">{{ $kullanici->ad . ' ' . $kullanici->soyad }}</span>
                </a>
                <div class="space-x-1.5">
                    <x-uniportal-dropdown class="!shadow-none !border-none !p-1" alignment="right">
                        <x-slot name="trigger">
                            <i class="bi bi-three-dots-vertical"></i>
                        </x-slot>

                        <x-slot name="target">
                            @if (auth()->id() !== $kullanici->kullanicilar_id)
                                <x-uniportal-dropdown-item href="javascript:void(0)" class="etkinlik-şikayet-et"
                                    data-id="{{ encrypt($paylasim->paylasimlar_id) }}">
                                    <i class="bi bi-flag-fill text-base text-orange-500"></i>
                                    <span class="ms-2">Şikayet et</span>
                                </x-uniportal-dropdown-item>
                            @endif
                            <x-uniportal-dropdown-item href="javascript:void(0)" class="paylasim-sil"
                                data-id="{{ encrypt($paylasim->paylasimlar_id) }}">
                                <i class="bi bi-trash-fill text-base text-gs-red-2"></i>
                                <span class="ms-2">Sil</span>
                            </x-uniportal-dropdown-item>
                        </x-slot>
                    </x-uniportal-dropdown>
                </div>
            </header>

            <section class="space-y-2 px-4 py-2 h-full group relative cursor-pointer open-paylasim-detay-modal"
                data-id="{{ encrypt($paylasim->paylasimlar_id) }}">
                <div
                    class="group-hover:opacity-100 opacity-0 bg-black/10 absolute top-0 left-0 w-full h-full duration-300">
                    <div class="flex items-center justify-center h-full">

                    </div>
                </div>

                <img src="{{ asset($paylasim->kapakFotoUrl) }}" class="w-full h-72 rounded object-cover" alt="">

                <div class="text-sm space-y-2">


                    <div class="text-ellipsis line-clamp-3">{{ $paylasim->aciklama }}</div>
                </div>
            </section>

            {{-- Butonlar --}}
            <footer class="flex gap-1 mt-auto px-4 py-2 border-t">
                <x-button class="!shadow-none !border-0 !p-2 paylasim-begen"
                    data-id="{{ encrypt($paylasim->paylasimlar_id) }}" :disabled="!auth()->check()">
                    <div class="flex items-center gap-2">
                        <i @class([
                            'bi text-red-500 text-base',
                            'bi-heart-fill' => $paylasim->begeniler->contains(
                                'kullanicilar_id',
                                auth()->id()),
                            'bi-heart' => !$paylasim->begeniler->contains(
                                'kullanicilar_id',
                                auth()->id()),
                        ])></i>
                        <span>{{ $paylasim->begeniler->count() }} </span>
                    </div>
                </x-button>
                <x-button class="!shadow-none !border-0 !p-2 open-etkinlik-detay-modal"
                    data-id="{{ encrypt($paylasim->paylasimlar_id) }}" data-focus="true">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-chat-left-text !text-blue-500 text-base"></i>
                        <span>{{ $paylasim->yorumlar->count() }}</span>
                    </div>
                </x-button>
                <x-button class="!shadow-none !border-0 !p-2 ml-auto share-btn">
                    <i class="bi bi-share-fill text-base"></i>
                </x-button>
            </footer>
        </div>
    @endforeach

    @if ($total > $limit)
        <div class="text-center py-2 sm:col-span-2 lg:col-span-3 xl:col-span-4">
            <x-button wire:click="loadMore">Daha fazla</x-button>
        </div>
    @endif
</section>
