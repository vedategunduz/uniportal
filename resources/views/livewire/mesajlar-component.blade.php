@php
    use Carbon\Carbon;

    $gunKodu = '';
@endphp

<div class="bg-gray-50 channel">
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
                                                <a href="javascript:void(0)"
                                                    data-form="mesaj-form-{{ $sifreliMesajlarId }}"
                                                    class="mesaj-duzenle flex items-center gap-2 px-4 py-2 hover:bg-gray-50 !text-amber-700 hover:text-amber-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                        height="12" fill="currentColor" class="bi bi-pencil-square"
                                                        viewBox="0 0 16 16">
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
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                        height="12" fill="currentColor" class="bi bi-trash3-fill"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                    </svg>
                                                    <span>
                                                        Sil
                                                    </span>
                                                </a>
                                            </li>
                                        @endif
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
                                                    class="mesaj-alintila flex items-center gap-2 px-4 py-2 hover:bg-gray-50 !text-rose-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                        height="12" fill="currentColor" class="bi bi-pin-angle-fill"
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

                <div class="max-w-">
                    <p class="text-xs">{{ $mesaj['kullanici']['ad'] . ' ' . $mesaj['kullanici']['soyad'] }}</p>
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
                                                    $saat = Carbon::parse(
                                                        $mesaj['alinti']['created_at'],
                                                    )->translatedFormat('H:i');
                                                    if ($mesaj['alinti']['durum'] == 'düzenlendi') {
                                                        $saat = Carbon::parse(
                                                            $mesaj['alinti']['updated_at'],
                                                        )->translatedFormat('H:i');
                                                        $saat .= ' (düzenlendi)';
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

                                <form action="{{ route('yonetim.mesaj.update', ['mesajId' => $sifreliMesajlarId]) }}"
                                    class="hidden" id="mesaj-form-{{ $sifreliMesajlarId }}">
                                    <div class="flex">
                                        <input type="hidden" name="mesajlar_id" value="{{ $sifreliMesajlarId }}" />

                                        @php
                                            $pattern = '/<a[^>]+href=["\'](https?:\/\/\S+?)["\'][^>]*>(.*?)<\/a>/i';
                                            $replacement = '$1';
                                            $duzenlenmisMesaj = preg_replace($pattern, $replacement, $mesaj['mesaj']);
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
                            @else
                                <span class="text-gray-500">Mesaj silindi</span>
                            @endif
                        </div>
                        <div class="text-right text-xs">
                            @php
                                $saat = Carbon::parse($mesaj['created_at'])->translatedFormat('H:i');
                                if ($mesaj['durum'] == 'düzenlendi') {
                                    $saat = Carbon::parse($mesaj['updated_at'])->translatedFormat('H:i');
                                    $saat .= ' (düzenlendi)';
                                }
                            @endphp
                            <small>
                                {{ $saat }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="">
        <form action="" class="p-4 mesaj-create-form">
            <input type="hidden" name="mesaj_kanallari_id" value="{{ $kanalId }}" />
            <input type="hidden" name="alintilanan_mesajlar_id" value="" alintiId />

            <div class="flex items-stretch">
                <x-textarea name="mesaj" rows="1"
                    class="!bg-white rounded-r-none max-h-48 overflow-auto hidden-scroll resize-none"></x-textarea>

                <x-button type="submit" class="mesaj-submit-button rounded-l-none border-l-0"
                    data-container="mesaj-container-{{ $kanalId }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-send-fill" viewBox="0 0 16 16">
                        <path
                            d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z" />
                    </svg>
                </x-button>
            </div>
        </form>
    </div>
</div>
