@php
    use Carbon\Carbon;

    $gunKodu = '';
@endphp

<div class="flex flex-col gap-2 px-4 py-3 overflow-auto mesaj-container h-96 hidden-scroll bg-motif"
    id="mesaj-container-{{ $kanalId }}">
    @if (count($mesajlar) === 0)
        <div class="text-center text-gray-500">Henüz mesaj yok</div>
    @else
        <div class="text-center">
            <button wire:click="dahaFazlaMesaj" class="text-blue-700 text-sm">Daha Fazla</button>
        </div>
    @endif
    @foreach ($mesajlar as $mesaj)
        @if ($gunKodu != Carbon::parse($mesaj['created_at'])->translatedFormat('Ymd'))
            <div class="text-gray-500 text-center text-sm">
                @php
                    $mesajTarihi = Carbon::parse($mesaj['created_at']);
                @endphp

                @if ($mesajTarihi->isToday())
                    Bugün
                @elseif ($mesajTarihi->isYesterday())
                    Dün
                @elseif ($mesajTarihi->greaterThanOrEqualTo(Carbon::now()->subDays(6)))
                    {{-- Son 7 gün içinde ise (bugün + son 6 gün) --}}
                    {{ $mesajTarihi->translatedFormat('l') }} {{-- Pazartesi, Salı, Çarşamba... --}}
                @else
                    {{ $mesajTarihi->translatedFormat('d F Y') }} {{-- 01 Ocak 2024 --}}
                @endif
            </div>
        @endif

        @php
            $gunKodu = Carbon::parse($mesaj['created_at'])->translatedFormat('Ymd');
            $sifreliMesajlarId = encrypt($mesaj['mesajlar_id']);
        @endphp

        <div @class([
            'flex gap-2 w-10/12 mesaj-wrapper',
            'flex-row-reverse ml-auto' => $mesaj['kullanicilar_id'] === auth()->id(),
        ])>
            <div class="flex flex-col items-center min-w-8">
                <img src="{{ $mesaj['kullanici']['profilFotoUrl'] }}" class="rounded-full w-8 h-8" alt="">

                @if ($mesaj['durum'] != 'silindi')
                    <div class="">
                        <button id="" data-dropdown-toggle="mesajDropdown-{{ $sifreliMesajlarId }}"
                            onmouseover="dropdownTrigger(this)"
                            class="flex items-center justify-between text-gray-900 p-1">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                    <path
                                        d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                </svg>
                            </div>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="mesajDropdown-{{ $sifreliMesajlarId }}"
                            class="z-20 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-48">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownLargeButton">
                                @if ($mesaj['kullanicilar_id'] === auth()->id())
                                    @if (Carbon::parse($mesaj['created_at'])->diffInMinutes() < 10)
                                        <li>
                                            <a href="javascript:void(0)" data-form="mesaj-form-{{ $sifreliMesajlarId }}"
                                                class="mesaj-duzenle flex items-center gap-2 px-4 py-2 hover:bg-gray-50 !text-amber-700 hover:text-amber-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                                <span>
                                                    Düzenle
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (Carbon::parse($mesaj['created_at'])->diffInMinutes() < 60)
                                        <li>
                                            <a href="javascript:void(0)" data-id="{{ $sifreliMesajlarId }}"
                                                class="mesaj-sil flex items-center gap-2 px-4 py-2 hover:bg-gray-50 !text-rose-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                </svg>
                                                <span>
                                                    Sil
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li class="flex items-stretch">
                                        @foreach ($emojiler as $emoji)
                                            <a href="javascript:void(0)" data-mesaj-id="{{ $sifreliMesajlarId }}"
                                                data-emoji-id="{{ encrypt($emoji->emoji_tipleri_id) }}"
                                                class="emoji-ekle inline-block px-4 py-2 hover:bg-gray-50 relative">
                                                {!! $emoji->url !!}

                                                @if ($mesaj['detay'])
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor"
                                                        @php $matchingDetail = collect($mesaj['detay'])->firstWhere('emoji_tipleri_id', $emoji->emoji_tipleri_id); @endphp
                                                        @class([
                                                            'bi bi-x absolute top-0 right-0.5',
                                                            'hidden' => !(
                                                                $matchingDetail && $matchingDetail['kullanicilar_id'] == auth()->id()
                                                            ),
                                                        ]) viewBox="0 0 16 16">
                                                        <path
                                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                    </svg>
                                                @endif
                                            </a>
                                        @endforeach
                                    </li>
                                @endif
                                <li>
                                    <a href="javascript:void(0)" data-id="{{ $sifreliMesajlarId }}"
                                        class="mesaj-alintila flex items-center gap-2 px-4 py-2 hover:bg-gray-50 !text-emerald-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                            fill="currentColor" class="bi bi-pin-angle-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146" />
                                        </svg>
                                        <span>
                                            Alıntıla
                                        </span>
                                    </a>
                                </li>
                                @if (!empty($mesaj['alinti']))
                                    @if ($mesaj['kullanicilar_id'] === auth()->id())
                                        <li>
                                            <a href="javascript:void(0)" data-id="{{ $sifreliMesajlarId }}"
                                                class="mesaj-alinti-kaldir flex items-center gap-2 px-4 py-2 hover:bg-gray-50 !text-pink-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                                    fill="currentColor" class="bi bi-pin-angle-fill"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M9.828.722a.5.5 0 0 1 .354.146l4.95 4.95a.5.5 0 0 1 0 .707c-.48.48-1.072.588-1.503.588-.177 0-.335-.018-.46-.039l-3.134 3.134a6 6 0 0 1 .16 1.013c.046.702-.032 1.687-.72 2.375a.5.5 0 0 1-.707 0l-2.829-2.828-3.182 3.182c-.195.195-1.219.902-1.414.707s.512-1.22.707-1.414l3.182-3.182-2.828-2.829a.5.5 0 0 1 0-.707c.688-.688 1.673-.767 2.375-.72a6 6 0 0 1 1.013.16l3.134-3.133a3 3 0 0 1-.04-.461c0-.43.108-1.022.589-1.503a.5.5 0 0 1 .353-.146" />
                                                </svg>
                                                <span>
                                                    Alıntıyı kaldır
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

            <div class="alintilanabilir relative">
                <p class="text-xs">
                    {{ $mesaj['kullanici']['ad'] . ' ' . $mesaj['kullanici']['soyad'] }}

                    @if (!empty($mesaj['isletme']))
                        ({{ $mesaj['isletme']['kisaltma'] }} -
                    @endif

                    @if (!empty($mesaj['unvan']))
                        {{ $mesaj['unvan']['baslik'] }})
                    @endif
                </p>
                <div @class([
                    'px-4 py-1 rounded shadow-sm',
                    'bg-emerald-50' => $mesaj['kullanicilar_id'] === auth()->id(),
                    'bg-blue-50' => $mesaj['kullanicilar_id'] !== auth()->id(),
                ])>

                    <div class="text-sm break-all mesaj-body">
                        @if ($mesaj['durum'] != 'silindi')
                            @if (!empty($mesaj['alinti']))
                                <p class="text-xs">
                                    @if ($mesaj['alinti']['kullanicilar_id'] === auth()->id())
                                        Siz
                                    @else
                                        {{ $mesaj['alinti']['kullanici']['ad'] . ' ' . $mesaj['alinti']['kullanici']['soyad'] }}
                                    @endif
                                </p>
                                <div @class([
                                    'px-4 py-1 rounded shadow-sm mb-2',
                                    'bg-emerald-100' => $mesaj['alinti']['kullanicilar_id'] === auth()->id(),
                                    'bg-blue-100' => $mesaj['alinti']['kullanicilar_id'] !== auth()->id(),
                                ])>
                                    @if ($mesaj['alinti']['durum'] != 'silindi')
                                        <span>{!! $mesaj['alinti']['mesaj'] !!}</span>

                                        <div class="text-right text-xs">
                                            @php
                                                $saat = new DateTime($mesaj['alinti']['created_at']);
                                                $saat->setTimezone(new DateTimeZone('Europe/Istanbul'));
                                                $saat = $saat->format('H:i');

                                                if ($mesaj['alinti']['durum'] == 'düzenlendi') {
                                                    $saat = new DateTime($mesaj['alinti']['updated_at']);
                                                    $saat->setTimezone(new DateTimeZone('Europe/Istanbul'));
                                                    $saat = $saat->format('H:i');
                                                    $saat .= ' düzenlendi';
                                                }
                                            @endphp
                                            <small>
                                                {{ $saat }}
                                            </small>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Mesaj silindi</span>
                                    @endif
                                </div>
                            @endif
                            <span>{!! $mesaj['mesaj'] !!}</span>

                            @if ($mesaj['kullanicilar_id'] === auth()->id())
                                    <form
                                        action="{{ route('yonetim.mesaj.update', ['mesajId' => $sifreliMesajlarId]) }}"
                                         id="mesaj-form-{{ $sifreliMesajlarId }}">
                                        <div class="hidden mesaj-form-child" wire:ignore>
                                            <input type="hidden" name="mesajlar_id"
                                                value="{{ $sifreliMesajlarId }}" />

                                            @php
                                                $pattern = '/<a[^>]+href=["\'](https?:\/\/\S+?)["\'][^>]*>(.*?)<\/a>/i';
                                                $replacement = '$1';
                                                $duzenlenmisMesaj = preg_replace(
                                                    $pattern,
                                                    $replacement,
                                                    $mesaj['mesaj'],
                                                );
                                            @endphp

                                            <x-textarea rows="1" name="mesaj"
                                                class="overflow-auto hidden-scroll">{{ $duzenlenmisMesaj }}</x-textarea>

                                            <x-button type="submit"
                                                class="mesaj-duzenle-submit-button !border-none !shadow-none !bg-transparent">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path
                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd"
                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                </svg>
                                            </x-button>
                                        </div>
                                    </form>
                            @endif
                        @else
                            <span class="text-gray-500">Mesaj silindi</span>
                        @endif
                    </div>
                    <div class="text-right text-xs">
                        @php
                            $saat = new DateTime($mesaj['created_at']);
                            $saat->setTimezone(new DateTimeZone('Europe/Istanbul'));
                            $saat = $saat->format('H:i');

                            if ($mesaj['durum'] == 'düzenlendi') {
                                $saat = new DateTime($mesaj['updated_at']);
                                $saat->setTimezone(new DateTimeZone('Europe/Istanbul'));
                                $saat = $saat->format('H:i');
                                $saat .= ' düzenlendi';
                            }
                        @endphp
                        <small>
                            {{ $saat }}
                        </small>
                    </div>
                </div>
                @if (!empty($mesaj['detay']) && $mesaj['durum'] != 'silindi')
                    @php
                        $kalp = 0;
                        $kirikKalp = 0;
                        $begen = 0;
                        $begenme = 0;

                        foreach ($mesaj['detay'] as $detay) {
                            if ($detay['emoji_tipleri_id'] == 1) {
                                $kalp++;
                            } elseif ($detay['emoji_tipleri_id'] == 2) {
                                $begen++;
                            } elseif ($detay['emoji_tipleri_id'] == 3) {
                                $kirikKalp++;
                            } elseif ($detay['emoji_tipleri_id'] == 4) {
                                $begenme++;
                            }
                        }
                    @endphp

                    <div
                        class="absolute -bottom-2 left-4 bg-white shadow-sm rounded-full py-1 px-2 text-xs flex items-center gap-2">

                        <a href="javascript:void(0)" @class([
                            'flex items-center gap-1 emoji-ekle',
                            'text-rose-500' => $kalp > 0,
                            'hidden' => $kalp === 0,
                        ]) data-emoji-id="{{ encrypt(1) }}"
                            data-mesaj-id="{{ $sifreliMesajlarId }}">
                            <span class="emoji-count">{{ $kalp }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-heart-fill !text-rose-500 size-3"
                                viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                            </svg>
                        </a>

                        <a href="javascript:void(0)" @class([
                            'flex items-center gap-1 emoji-ekle',
                            'text-yellow-300' => $begen > 0,
                            'hidden' => $begen === 0,
                        ]) data-emoji-id="{{ encrypt(2) }}"
                            data-mesaj-id="{{ $sifreliMesajlarId }}">
                            <span class="emoji-count">{{ $begen }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-hand-thumbs-up-fill !text-yellow-300 size-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z" />
                            </svg>
                        </a>

                        <a href="javascript:void(0)" @class([
                            'flex items-center gap-1 emoji-ekle',
                            'text-rose-500' => $kirikKalp > 0,
                            'hidden' => $kirikKalp === 0,
                        ]) data-emoji-id="{{ encrypt(3) }}"
                            data-mesaj-id="{{ $sifreliMesajlarId }}">
                            <span class="emoji-count">{{ $kirikKalp }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-heartbreak-fill !text-rose-500 size-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8.931.586 7 3l1.5 4-2 3L8 15C22.534 5.396 13.757-2.21 8.931.586M7.358.77 5.5 3 7 7l-1.5 3 1.815 4.537C-6.533 4.96 2.685-2.467 7.358.77" />
                            </svg>
                        </a>

                        <a href="javascript:void(0)" @class([
                            'flex items-center gap-1 emoji-ekle',
                            'text-yellow-300' => $begenme > 0,
                            'hidden' => $begenme === 0,
                        ]) data-emoji-id="{{ encrypt(4) }}"
                            data-mesaj-id="{{ $sifreliMesajlarId }}">
                            <span class="emoji-count">{{ $begenme }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-hand-thumbs-down-fill !text-yellow-300 size-3"
                                viewBox="0 0 16 16">
                                <path
                                    d="M6.956 14.534c.065.936.952 1.659 1.908 1.42l.261-.065a1.38 1.38 0 0 0 1.012-.965c.22-.816.533-2.512.062-4.51q.205.03.443.051c.713.065 1.669.071 2.516-.211.518-.173.994-.68 1.2-1.272a1.9 1.9 0 0 0-.234-1.734c.058-.118.103-.242.138-.362.077-.27.113-.568.113-.856 0-.29-.036-.586-.113-.857a2 2 0 0 0-.16-.403c.169-.387.107-.82-.003-1.149a3.2 3.2 0 0 0-.488-.9c.054-.153.076-.313.076-.465a1.86 1.86 0 0 0-.253-.912C13.1.757 12.437.28 11.5.28H8c-.605 0-1.07.08-1.466.217a4.8 4.8 0 0 0-.97.485l-.048.029c-.504.308-.999.61-2.068.723C2.682 1.815 2 2.434 2 3.279v4c0 .851.685 1.433 1.357 1.616.849.232 1.574.787 2.132 1.41.56.626.914 1.28 1.039 1.638.199.575.356 1.54.428 2.591" />
                            </svg>
                        </a>


                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
