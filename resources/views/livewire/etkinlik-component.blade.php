@php
    use Carbon\Carbon;
@endphp
<section class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
        <h4 class="text-lg px-2 font-semibold text-gray-900 uppercase tracking-widest">Etkinlikler</h4>
    </div>
    @foreach ($etkinlikler as $etkinlik)
        @php
            $tarih = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d F Y H:i');
            $tarih2 = Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d F Y H:i');
        @endphp
        <div class="flex flex-col shadow border rounded text-gray-700 bg-white">
            <header class="border-b py-1.5 px-4 flex justify-between items-center rounded-t">
                <a href="#" class="flex items-center gap-2">
                    <img src="{{ $etkinlik->isletme->logoUrl }}" class="size-8 rounded-full object-contain" loading="lazy" alt="">

                    <span class="text-xs font-medium ">{{ $etkinlik->isletme->kisaltma }}</span>
                </a>
                <div class="space-x-1.5">
                    <span
                        class="font-medium px-1.5 py-0.5 text-xs bg-blue-7100 text-white rounded {{ $etkinlik->tur->class }}">
                        {{ $etkinlik->tur->baslik }}
                    </span>

                    <x-uniportal-dropdown class="!shadow-none !border-none !p-1" alignment="right">
                        <x-slot name="trigger">
                            <i class="bi bi-three-dots-vertical"></i>
                        </x-slot>

                        <x-slot name="target">
                            <x-uniportal-dropdown-item href="#">
                                <i class="bi bi-calendar-range-fill text-base text-green-400"></i>
                                <span class="ms-2">Takivime ekle</span>
                            </x-uniportal-dropdown-item>
                            <x-uniportal-dropdown-item href="javascript:void(0)" class="etkinlik-şikayet-et"
                                data-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
                                <i class="bi bi-flag-fill text-base text-orange-500"></i>
                                <span class="ms-2">Şikayet et</span>
                            </x-uniportal-dropdown-item>
                        </x-slot>
                    </x-uniportal-dropdown>
                </div>
            </header>

            <section class="space-y-2 px-4 py-2 h-full group relative cursor-pointer open-etkinlik-detay-modal"
                data-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
                <div
                    class="group-hover:opacity-100 opacity-0 bg-black/10 absolute top-0 left-0 w-full h-full duration-300">
                    <div class="flex items-center justify-center h-full">
                        {{-- <x-button class="!shadow-none !border-0 !p-2 !bg-transparent text-white font-black !capitalize !text-xl">
                            <span class="drop-shadow-md">detay</span>
                        </x-button> --}}
                    </div>
                </div>

                <img src="{{ $etkinlik->kapakResmiYolu }}" class="w-full h-72 rounded object-cover" alt="">

                <div class="text-sm space-y-2">
                    <p class="text-right">
                        <span class="px-1.5 py-0.5 text-xs bg-green-400 text-white rounded">
                            {{ $tarih }}
                        </span>
                    </p>

                    <p class="font-medium text-base">{{ $etkinlik->baslik }}</p>

                    <div class="text-ellipsis line-clamp-3">{!! cleanText($etkinlik->aciklama) !!}</div>
                </div>
            </section>

            {{-- Butonlar --}}
            <footer class="flex gap-1 mt-auto px-4 py-2 border-t">
                <x-button class="!shadow-none !border-0 !p-2 etkinlik-begen"
                    data-id="{{ encrypt($etkinlik->etkinlikler_id) }}" :disabled="!auth()->check()">
                    <div class="flex items-center gap-2">
                        <i @class([
                            'bi text-red-500 text-base',
                            'bi-heart-fill' => $etkinlik->begeni->contains(
                                'kullanicilar_id',
                                auth()->id()),
                            'bi-heart' => !$etkinlik->begeni->contains('kullanicilar_id', auth()->id()),
                        ])></i>
                        <span>{{ $etkinlik->begeni->count() }} </span>
                    </div>
                </x-button>
                <x-button class="!shadow-none !border-0 !p-2 open-etkinlik-detay-modal"
                    data-id="{{ encrypt($etkinlik->etkinlikler_id) }}" data-focus="true">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-chat-left-text !text-blue-500 text-base"></i>
                        <span>{{ $etkinlik->yorum->count() }}</span>
                    </div>
                </x-button>
                <x-button class="!shadow-none !border-0 !p-2 ml-auto share-btn">
                    <i class="bi bi-share-fill text-base"></i>
                </x-button>
            </footer>
        </div>
    @endforeach
    @if ($this->etkinlikler->count() < $totalEtkinlik)
        <div class="text-center py-2 sm:col-span-2 lg:col-span-3 xl:col-span-4">
            <x-button wire:click="loadMore">Daha fazla</x-button>
        </div>
    @endif
</section>
