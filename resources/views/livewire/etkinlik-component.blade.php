@php
    use Carbon\Carbon;
@endphp
<section class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    @foreach ($etkinlikler as $etkinlik)
        @php
            $tarih = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d F Y H:i');
            $tarih2 = Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d F Y H:i');
            $aciklama = $etkinlik->aciklama;

            if (strlen($aciklama) > 100) {
                $aciklama = substr($aciklama, 0, 100) . '...';
            }
        @endphp
        <div class="flex flex-col shadow border rounded text-gray-700">
            <section class="border-b py-1.5 px-4 flex justify-between items-center rounded-t">
                <a href="#" class="flex items-center gap-2">
                    <img src="{{ $etkinlik->isletme->logoUrl }}" class="size-8 rounded-full object-contain" alt="">

                    <span class="text-xs font-medium ">{{ $etkinlik->isletme->kisaltma }}</span>
                </a>
                <span
                    class="absolute1 top-2 right-2 font-medium px-1.5 py-0.5 text-xs bg-blue-7100 text-white rounded {{ $etkinlik->tur->class }}">
                    {{ $etkinlik->tur->baslik }}</span>
            </section>

            <section class="space-y-2 px-4 py-2 h-full group relative cursor-pointer open-etkinlik-detay-modal" data-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
                <div class="group-hover:opacity-100 opacity-0 bg-black/20 absolute top-0 left-0 w-full h-full duration-300">
                    <div class="flex items-center justify-center h-full">
                        <x-button class="!shadow-none !border-0 !p-2 !bg-transparent text-white font-black !capitalize !text-xl">
                            <span class="drop-shadow-md">detay</span>
                        </x-button>
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

                    <p>{{ $aciklama }}</p>
                </div>
            </section>

            {{-- Butonlar --}}
            <section class="flex gap-1 mt-auto px-4 py-2 border-t">
                <x-button class="!shadow-none !border-0 !p-2" :disabled="!auth()->check()">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-heart-fill !text-rose-500" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                        </svg>
                        <span>{{ $etkinlik->begeni->count() }} </span>
                    </div>
                </x-button>
                <x-button class="!shadow-none !border-0 !p-2 open-etkinlik-detay-modal" data-id="{{ encrypt($etkinlik->etkinlikler_id) }}" data-focus="true">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-chat-left-text-fill !text-blue-500" viewBox="0 0 16 16">
                            <path
                                d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z" />
                        </svg>
                        <span>{{ $etkinlik->yorum->count() }}</span>
                    </div>
                </x-button>
                @auth
                    <x-button class="!shadow-none !border-0 !px-2 text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                            <path fill-rule="evenodd"
                                d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5" />
                        </svg>
                        <span class="text-xs ms-1 capitalize">Katıl</span>
                    </x-button>
                @endauth
                <x-button class="!shadow-none !border-0 !p-2 ml-auto share-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-share-fill" viewBox="0 0 16 16">
                        <path
                            d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                    </svg>
                </x-button>
            </section>
        </div>
    @endforeach
</section>
