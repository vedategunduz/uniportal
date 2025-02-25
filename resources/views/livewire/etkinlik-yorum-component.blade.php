<section>
    <h4 class="font-medium text-lg px-4 py-2 bg-gray-50 border-b text-gray-900">Yorumlar</h4>
    <div class="flex flex-col px-4 py-2 gap-4">
        <!-- Tek Yorum -->
        @foreach ($yorumlar as $yorum)
            <div class="flex items-start gap-2">
                <img src="{{ $yorum->kullanici->profilFotoUrl }}" class="size-10 rounded-full" alt="Yorum Yapan">
                <div class="w-full text-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">
                                {{ $yorum->kullanici->ad . ' ' . $yorum->kullanici->soyad }}
                                ({{ $yorum->kullanici->anaIsletme->kisaltma }})
                            </p>
                            <p class="text-gray-600">{{ $yorum->yorum }}</p>
                        </div>
                        <x-button
                            class="!shadow-none !border-0 !p-2 hover:!bg-transparent !text-base etkinlik-yorum-begen"
                            data-yorum-id="{{ encrypt($yorum->etkinlik_yorumlari_id) }}"
                            data-etkinlik-id="{{ encrypt($yorum->etkinlikler_id) }}"
                            :disabled="!auth()->check()">
                            @if ($yorum->begeni->contains('kullanicilar_id', auth()->id()))
                                <i class="bi bi-heart-fill text-sm text-rose-500"></i>
                            @else
                                <i class="bi bi-heart text-sm"></i>
                            @endif
                        </x-button>
                    </div>
                    <div class="flex items-center gap-2 mt-1">
                        <p class="font-semibold text-xs text-gray-500">
                            {{ $yorum->created_at->diffForHumans() }}
                        </p>
                        @if ($yorum->begeni->count())
                            <p class="font-semibold text-xs text-gray-500">
                                {{ $yorum->begeni->count() }} beğenme
                            </p>
                        @endif
                        @if ($yorum->yanit->count())
                            <x-button
                                class="!shadow-none !border-0 !p-0 !text-gray-500 hover:!underline hover:!bg-transparent">
                                <span class="text-xs tracking-normal normal-case">Yanıtları gör
                                    ({{ $yorum->yanit->count() }})</span>
                            </x-button>
                        @endif
                        <x-button
                            class="!shadow-none !border-0 !p-0 !text-blue-500 hover:!underline hover:!bg-transparent">
                            Yanıtla
                        </x-button>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Diğer yorumlar buraya eklenebilir -->
    </div>
</section>
