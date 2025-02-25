@php
    use Carbon\Carbon;

    $tarih = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D, Y, h:i');

    $tarih2 = Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D, Y, h:i');
@endphp
<section class="grid lg:grid-cols-2 h-full">
    <!-- Sol Kolon: Etkinlik Kapak Resmi -->
    <div class="p-2">
        <img src="{{ $etkinlik->kapakResmiYolu }}" class="lg:h-[90vh] object-cover rounded" alt="Etkinlik Kapak Resmi">
    </div>

    <!-- Sağ Kolon: Etkinlik Detayları & Yorumlar -->
    <div class="border-l flex flex-col">
        <!-- Üst Bilgi: İşletme Bilgisi & Etkinlik Türü -->
        <header class="border-b py-1.5 px-4 flex justify-between items-center relative">
            <a href="#" class="flex items-center gap-2">
                <img src="{{ $etkinlik->isletme->logoUrl }}" class="size-8 rounded-full object-contain"
                    alt="İşletme Logosu">
                <span class="text-sm font-medium text-gray-900">{{ $etkinlik->isletme->baslik }}</span>
            </a>
            <span
                class="absolute top-2 right-2 font-medium px-1.5 py-0.5 text-xs text-white rounded {{ $etkinlik->tur->class }}">
                {{ $etkinlik->tur->baslik }}
            </span>
        </header>

        <!-- Ana İçerik: Etkinlik Detayları & Yorumlar -->
        <section class="overflow-y-auto custom-scroll lg:h-[calc(90vh-140px)]">
            <!-- Etkinlik Detayları -->
            <article class="px-4 py-2 space-y-2 border-b">
                <h4 class="font-medium text-xl mb-2">{{ $etkinlik->baslik }}</h4>
                <div class="font-light text-sm flex flex-wrap items-center gap-1">
                    <p class="px-1.5 py-0.5 bg-green-400 text-white rounded">{{ $tarih }}</p>
                    <span>-</span>
                    <p class="px-1.5 py-0.5 bg-blue-400 text-white rounded">{{ $tarih2 }}</p>
                </div>
                <p class="text-gray-800 leading-relaxed text-sm show-more-text text-ellipsis line-clamp-3">
                    {{ $etkinlik->aciklama }}
                </p>
            </article>

            <!-- Yorumlar Bölümü -->
            <livewire:etkinlik-yorum-component :yorumlar="$etkinlik->yorum" />
        </section>

        <!-- Alt Kısım: Etkileşim Butonları & Yorum Girişi -->
        <footer class="mt-auto">
            <!-- Etkileşim Butonları -->
            <div class="flex gap-2 px-4 py-2 border-t">
                <x-button class="!shadow-none !border-0 !p-2" :disabled="!auth()->check()">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-heart-fill !text-rose-500" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                        </svg>
                        <span>{{ $etkinlik->begeni->count() }}</span>
                    </div>
                </x-button>

                <x-button class="!shadow-none !border-0 !p-2" :disabled="true">
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
            </div>

            <!-- Yorum Girişi -->
            <div class="flex items-center justify-between gap-2 px-4 py-2 border-t">
                <x-textarea rows="1" name="yorum" class="overflow-auto custom-scroll max-h-32"
                    :disabled="!auth()->check()">
                    @guest
                        Yorum yapabilmek için giriş yapmalısınız.
                    @endguest
                </x-textarea>
                <x-button class="shrink-0" :disabled="!auth()->check()">Yorum yap</x-button>
            </div>
        </footer>
    </div>
</section>
