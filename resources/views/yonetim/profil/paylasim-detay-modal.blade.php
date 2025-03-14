@php
    use Carbon\Carbon;
@endphp
<section class="grid grid-cols-1 lg:grid-cols-2 h-full" data-modal>
    <!-- Sol Kolon: paylasim Kapak Resmi -->
    <div class="p-2">
        <div class="swiper relative">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slider main container -->
                <div class="swiper-slide">
                    <img src="{{ $paylasim->kapakFotoUrl }}" class="lg:h-[72vh] object-contain rounded mx-auto"
                        alt="paylasim Kapak Resmi">
                </div>
                {{-- @if ($paylasim->resimler->count())
                    @foreach ($paylasim->resimler as $resim)
                        <!-- Slider main container -->
                        <div class="swiper-slide">
                            <img src="{{ $resim->dosyaYolu }}" class="lg:h-[72vh] object-contain rounded mx-auto"
                                alt="">
                        </div>
                    @endforeach
                @endif --}}
            </div>
            <div class="sm:hidden swiper-button-next"></div>
            <div class="sm:hidden swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Sağ Kolon: paylasim Detayları & Yorumlar -->
    <div class="border-l flex flex-col">
        <!-- Üst Bilgi: İşletme Bilgisi & paylasim Türü -->
        <header class="border-b py-1.5 px-4 flex justify-between items-center relative">
            <a href="{{ route('yonetim.kullanici.show', encrypt($kullanici->kullanicilar_id)) }}"
                class="flex items-center gap-2">
                <img src="{{ $kullanici->profilFotoUrl }}" class="size-8 rounded-full object-contain" loading="lazy"
                    alt="">

                <span class="text-xs font-medium ">{{ $kullanici->ad . ' ' . $kullanici->soyad }}</span>
            </a>
        </header>

        <!-- Ana İçerik: paylasim Detayları & Yorumlar -->
        <section class="overflow-y-auto custom-scroll lg:h-[calc(90vh-140px)] scroll-smooth" data-modal-content>
            <!-- paylasim Detayları -->
            <article class="px-4 py-2 space-y-2 border-b">
                <div
                    class="text-gray-800 leading-relaxed text-sm text-ellipsis show-more-text line-clamp-3 text-wrap break-words">
                    {{ $paylasim->aciklama }}
                </div>
            </article>

            <!-- Yorumlar Bölümü -->
            <livewire:kullanici-paylasim-yorum-component :key="encrypt($paylasim->paylasimlar_id)" :paylasimid="encrypt($paylasim->paylasimlar_id)" />
        </section>

        <!-- Alt Kısım: Etkileşim Butonları & Yorum Girişi -->
        <footer class="mt-auto">
            <!-- Etkileşim Butonları -->
            <section class="flex gap-2 px-4 py-2 border-t">
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
                <x-button class="!shadow-none !border-0 !p-2 open-paylasim-detay-modal"
                    data-id="{{ encrypt($paylasim->paylasimlar_id) }}" data-focus="true">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-chat-left-text !text-blue-500 text-base"></i>
                        <span>{{ $paylasim->yorumlar->count() }}</span>
                    </div>
                </x-button>
                <x-button class="!shadow-none !border-0 !px-2 !py-1 share-btn">
                    <i class="bi bi-share-fill text-base"></i>
                </x-button>
            </section>
            <!-- Yorum Girişi -->
            <form action="{{ route('yonetim.kullanici.paylasim.yorum.store', encrypt($paylasim->paylasimlar_id)) }}"
                class="border-t" method="POST" data-paylasim-yorum-form>
                <section class="flex items-center justify-between gap-2 px-4 py-2">
                    <!-- Yorum textarea -->
                    <x-textarea rows="1" name="yorum" class="custom-scroll max-h-24" :disabled="!auth()->check() || !$paylasim->yorumDurumu">
                        @if (auth()->check())
                            @if (!$paylasim->yorumDurumu)
                                Yoruma kapalıdır.
                            @endif
                        @else
                            Yorum yapabilmek için giriş yapmalısınız.
                        @endif
                    </x-textarea>

                    <!-- Yorum yap butonu -->
                    <x-button class="shrink-0 paylasim-yorum-submit-button" :disabled="!auth()->check() || !$paylasim->yorumDurumu">
                        Yorum yap
                    </x-button>
                </section>
            </form>
        </footer>
    </div>
</section>
