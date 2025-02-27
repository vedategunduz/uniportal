@php
    use Carbon\Carbon;
@endphp
<section class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
    <div class="sm:col-span-2 lg:col-span-3 xl:col-span-5">
        <h4 class="text-lg px-2 font-semibold text-gray-900 uppercase tracking-widest">Kampanyalar</h4>
    </div>
    @foreach ($etkinlikler as $etkinlik)
        @php
            $tarih = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d F');
            $tarih2 = Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d F Y');
        @endphp
        <div class="flex flex-col shadow border rounded text-gray-700">
            <header class="border-b py-1.5 px-4 flex justify-between items-center rounded-t">
                <a href="#" class="flex items-center gap-2">
                    <img src="{{ $etkinlik->isletme->logoUrl }}" class="size-8 rounded-full object-contain" alt="">

                    <span class="text-xs font-medium ">{{ $etkinlik->isletme->kisaltma }}</span>
                </a>
                <span
                    class="font-medium px-1.5 py-0.5 text-xs bg-blue-7100 text-white rounded {{ $etkinlik->tur->class }}">
                    {{ $etkinlik->tur->baslik }}</span>
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

                <img src="{{ $etkinlik->kapakResmiYolu }}" class="w-full h-48 rounded object-cover mx-auto" alt="">

                <div class="text-sm space-y-2">
                    <p class="text-right ">
                        <span
                            @class([
                                'px-1.5 py-0.5 text-xs text-white rounded',
                                'bg-green-400' => $today->between($etkinlik->etkinlikBaslamaTarihi, $etkinlik->etkinlikBitisTarihi),
                                'bg-gs-red' => $today->gt($etkinlik->etkinlikBitisTarihi),
                                'bg-yellow-400' => $today->lt($etkinlik->etkinlikBaslamaTarihi),
                            ])
                        >
                            {{ $tarih }} - {{ $tarih2 }}
                        </span>
                    </p>

                    <p class="font-medium text-base text-ellipsis line-clamp-2">{{ $etkinlik->baslik }}</p>

                    {{-- <p class="text-ellipsis line-clamp-1">{!! $etkinlik->aciklama !!}</p> --}}
                </div>
            </section>

            {{-- Butonlar --}}
            <footer class="flex gap-1 mt-auto px-4 py-1 border-t">
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
                {{-- @auth
                    <x-button class="!shadow-none !border-0 !px-2 text-green-400">
                        <i class="bi bi-person-plus-fill text-base"></i>
                        <span class="text-xs ms-1 capitalize">Katıl</span>
                    </x-button>
                @endauth --}}
                <x-button class="!shadow-none !border-0 !p-2 ml-auto share-btn">
                    <i class="bi bi-share-fill text-base"></i>
                </x-button>
            </footer>
        </div>
    @endforeach
    @if ($this->etkinlikler->count() < $totalEtkinlik)
        <div class="text-center py-2 sm:col-span-2 lg:col-span-3 xl:col-span-5">
            <x-button wire:click="loadMore">Daha fazla</x-button>
        </div>
    @endif
</section>
