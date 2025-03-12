@php
    use Carbon\Carbon;

    $tarih = Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D, Y, h:i');

    $tarih2 = Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D, Y, h:i');

    $tarih3 = Carbon::parse($etkinlik->etkinlikBasvuruTarihi)->translatedFormat('d M, D, Y, h:i');

    $tarih4 = Carbon::parse($etkinlik->etkinlikBasvuruBitisTarihi)->translatedFormat('d M, D, Y, h:i');

@endphp
<section class="grid grid-cols-1 lg:grid-cols-2 h-full" data-modal>
    <!-- Sol Kolon: Etkinlik Kapak Resmi -->
    <div class="p-2">
        <div class="swiper relative">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slider main container -->
                <div class="swiper-slide">
                    <img src="{{ $etkinlik->kapakResmiYolu }}" class="lg:h-[72vh] object-contain rounded mx-auto"
                        alt="Etkinlik Kapak Resmi">
                </div>
                @if ($etkinlik->resimler->count())
                    @foreach ($etkinlik->resimler as $resim)
                        <!-- Slider main container -->
                        <div class="swiper-slide">
                            <img src="{{ $resim->dosyaYolu }}" class="lg:h-[72vh] object-contain rounded mx-auto"
                                alt="">
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="sm:hidden swiper-button-next"></div>
            <div class="sm:hidden swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
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
        <section class="overflow-y-auto custom-scroll lg:h-[calc(90vh-140px)] scroll-smooth" data-modal-content>
            <!-- Etkinlik Detayları -->
            <article class="px-4 py-2 space-y-2 border-b">
                <h4 class="font-medium text-xl mb-2">{{ $etkinlik->baslik }}</h4>
                <div class="font-light text-sm flex flex-wrap items-center justify-between gap-1">
                    <p class="px-1.5 py-0.5 border font-medium rounded">
                        Başlama Tarihi&nbsp;&nbsp;:
                        <span class="text-green-400">{{ $tarih }}</span> -
                        <span class="text-red-400">{{ $tarih2 }}</span>
                    </p>
                    @if (!empty($etkinlik->il))
                        <p class="px-1.5 py-0.5 bg-violet-400 text-white rounded">{{ $etkinlik->il->baslik }}</p>
                    @endif
                </div>
                @if (!empty($etkinlik->etkinlikBasvuruTarihi) && !empty($etkinlik->etkinlikBasvuruBitisTarihi))
                    <div class="font-light text-sm flex flex-wrap items-center gap-1">
                        <p class="px-1.5 py-0.5 border font-medium rounded">
                            Başvuru Tarihi:
                            <span class="text-green-400">{{ $tarih3 }}</span> -
                            <span class="text-red-400">{{ $tarih4 }}</span>
                        </p>
                    </div>
                @endif
                <div
                    class="text-gray-800 leading-relaxed text-sm text-ellipsis line-clamp-3 default text-wrap break-words editor-gosterim">
                    {!! $etkinlik->aciklama !!}

                    @if (!empty($etkinlik->harita))
                        <div class="hidden iframe mt-4" data-iframe>
                            {{ $etkinlik->harita }}
                        </div>
                    @endif
                </div>

                <button class="show-more-wrapper">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </button>
            </article>

            <!-- Yorumlar Bölümü -->
            <livewire:etkinlik-yorum-component :key="encrypt($etkinlik->etkinlikler_id)" :etkinlikid="$etkinlik->etkinlikler_id" />
        </section>

        <!-- Alt Kısım: Etkileşim Butonları & Yorum Girişi -->
        <footer class="mt-auto">
            <!-- Etkileşim Butonları -->
            <section class="flex gap-2 px-4 py-2 border-t">
                <x-button class="!shadow-none !border-0 !px-2 !py-1 etkinlik-begen"
                    data-id="{{ encrypt($etkinlik->etkinlikler_id) }}" :disabled="!auth()->check()">
                    <div class="flex items-center gap-2">
                        <i @class([
                            'bi text-red-500 text-base',
                            'bi-heart-fill' => $etkinlik->begeni->contains(
                                'kullanicilar_id',
                                auth()->id()),
                            'bi-heart' => !$etkinlik->begeni->contains('kullanicilar_id', auth()->id()),
                        ])></i>
                        <span>{{ $etkinlik->begeni->count() }}</span>
                    </div>
                </x-button>

                @auth
                    @if (!$etkinlik->katilimcilar->contains('kullanicilar_id', auth()->id()))
                        <x-button class="!shadow-none !border-0 !px-2 !py-1 text-green-400 etkinlik-katil-modal"
                            data-id="{{ encrypt($etkinlik->etkinlikler_id) }}">
                            <i class="bi bi-person-plus-fill text-base"></i>
                            <span class="text-xs ms-1 capitalize">Katıl</span>
                        </x-button>
                    @endif

                    @if (auth()->user()->anaIsletme->tur->isletme_turleri_id == 1)
                        <div class="ml-auto flex items-center">
                            <x-switch class="kamu-yorumlari-switch">
                                Kamu yorumları ({{ $etkinlik->yorum->where('yorum_tipi', 1)->count() }})
                            </x-switch>
                        </div>
                    @endif
                @endauth

                <x-button class="!shadow-none !border-0 !px-2 !py-1 share-btn">
                    <i class="bi bi-share-fill text-base"></i>
                </x-button>
            </section>
            <!-- Yorum Girişi -->
            <form action="{{ route('etkinlikler.yorum.store', [encrypt($etkinlik->etkinlikler_id)]) }}"
                class="border-t" method="POST" data-etkinlik-yorum-form>
                <section class="flex items-center justify-between gap-2 px-4 py-2">
                    <!-- Yorum textarea -->
                    <x-textarea rows="1" name="yorum" class="custom-scroll max-h-24" :disabled="!auth()->check() || !$etkinlik->yorumDurumu">
                        @if (auth()->check())
                            @if (!$etkinlik->yorumDurumu)
                                Yoruma kapalıdır.
                            @endif
                        @else
                            Yorum yapabilmek için giriş yapmalısınız.
                        @endif
                    </x-textarea>

                    <!-- Yorum yap butonu -->
                    <x-button class="shrink-0 etkinlik-yorum-submit-button" :disabled="!auth()->check() || !$etkinlik->yorumDurumu">
                        Yorum yap
                    </x-button>
                </section>
            </form>
        </footer>
    </div>
</section>
