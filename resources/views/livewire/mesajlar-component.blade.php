<div class="bg-gray-50">
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
            <div @class([
                'flex gap-2 w-10/12',
                'flex-row-reverse ml-auto' => $mesaj['kullanicilar_id'] === auth()->id(),
            ])>
                <img src="{{ $mesaj['kullanici']['profilFotoUrl'] }}" class="rounded-full size-8" alt="">

                <div class="">
                    <p class="text-xs">{{ $mesaj['kullanici']['ad'] . ' ' . $mesaj['kullanici']['soyad'] }}</p>
                    <div @class([
                        'px-4 py-2 rounded shadow-sm',
                        'bg-emerald-50' => $mesaj['kullanicilar_id'] === auth()->id(),
                        'bg-blue-50' => $mesaj['kullanicilar_id'] !== auth()->id(),
                    ])>
                        <p class="text-sm break-all">{!! $mesaj['mesaj'] !!}</p>
                        <div class="text-right text-xs">
                            @php
                                $tarih = (new DateTime($mesaj['created_at']))->format('H:i');
                            @endphp
                            <small>{{ $tarih }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <form action="" class="p-4">
        <input type="hidden" name="mesaj_kanallari_id" value="{{ $kanalId }}" />

        <div class="flex items-stretch">
            <x-text-input type="text" name="mesaj" class="rounded-r-none" placeholder="" />

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
