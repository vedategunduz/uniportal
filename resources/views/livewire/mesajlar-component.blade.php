<div class="flex flex-col justify-between gap-2 px-4 py-3">
    @foreach ($mesajlar as $mesaj)
        <div @class([
            'flex w-10/12',
            'flex-row-reverse ml-auto' => $mesaj['kullanicilar_id'] === auth()->id(),
        ])>
            <div @class([
                'p-4 rounded',
                'bg-emerald-50' => $mesaj['kullanicilar_id'] === auth()->id(),
                'bg-blue-50' => $mesaj['kullanicilar_id'] !== auth()->id(),
            ])>
                <p class="text-sm">{{ $mesaj['mesaj'] }}</p>
                <div class="text-right">
                    @php
                        $tarih = (new DateTime($mesaj['created_at']))->format('H:i');
                    @endphp
                    <small>{{ $tarih }}</small>
                </div>
            </div>
        </div>
    @endforeach
    <form action="">
        <input type="hidden" name="mesaj_kanallari_id" value="{{ $kanalId }}" />

        <input type="text" name="mesaj">
        <button class="mesaj-submit-button">Gönder</button>
    </form>
</div>
