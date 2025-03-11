<section>
    <form
        action="{{ $etkinlik ? route('yonetim.toplantilar.ziyaretler.update', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) : route('yonetim.toplantilar.ziyaretler.store') }}"
        method="POST" enctype="multipart/form-data">

        @if ($etkinlik)
            @method('PATCH')
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-4">
                <x-relative-input type="text" name="baslik" label="Ziyaret adı"
                    value="{{ optional($etkinlik)->baslik }}" required />

                <div class="grid sm:grid-cols-2 gap-2">
                    <x-datetime name="etkinlikBaslamaTarihi" label="Ziyaret tarihi"
                        value="{{ optional($etkinlik)->etkinlikBaslamaTarihi }}" />
                    <x-datetime name="etkinlikBitisTarihi" label="Planlanan bitiş tarihi"
                        value="{{ optional($etkinlik)->etkinlikBitisTarihi }}" />
                </div>

                <div>
                    <p class="text-lg font-medium text-gray-900 mb-0">Ziyaret Açıklaması</p>
                    <textarea id="aciklama" name="aciklama" class="w-full">{{ optional($etkinlik)->aciklama }}</textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                <!-- Ziyaret Eden Kurum (Kendi Kurumunuz) -->
                <section class="space-y-4">
                    <p class="text-lg font-medium text-gray-900 mb-0">Ziyaret Eden Kurum</p>
                    <label for="giden_isletme" class="sr-only">İşletme Seçimi</label>
                    <select id="giden_isletme" name="giden_isletme_id" {{ $etkinlik ? 'disabled' : '' }}
                        class="w-full border border-gray-300 rounded py-1.5">
                        @if (auth()->user()->isletmeler->count() > 1)
                            <option value="">İşletme seçiniz</option>
                        @endif
                        @foreach (auth()->user()->isletmeler as $detay)
                            <option value="{{ encrypt($detay->isletme->isletmeler_id) }}"
                                {{ $etkinlik && $etkinlik->isletmeler_id == $detay->isletme->isletmeler_id ? 'selected' : '' }}>
                                {{ $detay->isletme->baslik }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Kendi kurum personelinde arama -->
                    <x-relative-input name="kendi_kurum_personeli_ara" label="Kendi kurum personelinde ara" />

                    <p class="text-lg font-medium text-gray-900 mb-0 border-b pb-2">Ziyaret Ekibi
                        <span class="text-sm font-normal">(İletişim bilgileriniz paylaşılacaktır.)</span>
                    </p>

                    <div class="relative">
                        <div id="kendiKurumPersonelListesi"
                            class="max-h-80 overflow-y-auto absolute top-0 left-0 bg-white z-20 w-full shadow border rounded !hidden">
                        </div>
                    </div>

                    <div id="kendiKurumSeciliPersoneller" class="space-y-2 max-h-80 overflow-y-auto">
                        @if ($etkinlik)
                            @foreach ($etkinlik->gidenKatilimcilar as $giden)
                                <x-yonetim.toplanti.kullanici :kullanici="$giden->kullanici" :durum="$giden->durum" />
                            @endforeach
                        @else
                            <x-yonetim.toplanti.kullanici :kullanici="auth()->user()" durum="beklemede" type="giden" />
                        @endif
                    </div>
                </section>

                <!-- Ziyaret Edilen Kurum -->
                <section class="space-y-4">
                    <p class="text-lg font-medium text-gray-900 mb-0">Ziyaret Edilen Kurum</p>
                    <label for="gidilen_isletme" class="sr-only">Kurum Seçimi</label>
                    <select id="gidilen_isletme" name="gidilen_isletme_id" {{ $etkinlik ? 'disabled' : '' }}
                        class="w-full border border-gray-300 rounded py-1.5">
                        <option value="">Kurum seçiniz...</option>
                        @foreach ($tum_isletmeler as $isletme)
                            <option value="{{ encrypt($isletme->isletmeler_id) }}"
                                {{ $etkinlik && $etkinlik->gidilen_isletmeler_id == $isletme->isletmeler_id ? 'selected' : '' }}>
                                {{ $isletme->baslik }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Ziyaret edilecek kurum personelinde arama -->
                    <x-relative-input name="ziyaret_edilen_kurum_personeli_ara"
                        label="Ziyaret edilen kurum personelinde ara" />

                    <p class="text-lg font-medium text-gray-900 mb-0 border-b pb-2">Kurum Ekibi</p>

                    <div class="relative">
                        <div id="ziyaretEdilenKurumPersonelListesi"
                            class="max-h-80 overflow-y-auto absolute top-0 left-0 bg-white z-20 w-full shadow border rounded !hidden">

                        </div>
                    </div>

                    <div id="ziyaretEdilenKurumSeciliPersoneller" class="space-y-2 pb-12 max-h-80 overflow-y-auto">
                        @if ($etkinlik)
                            @foreach ($etkinlik->gidilenKatilimcilar as $giden)
                                <x-yonetim.toplanti.kullanici :kullanici="$giden->kullanici" :durum="$giden->durum" />
                            @endforeach
                        @endif
                    </div>
                </section>
            </div>
        </div>

        <!-- Form Butonu -->
        <div class="text-right">
            <x-button type="submit"
                class="etkinlik-submit-button justify-center w-full !border-none !text-white !tracking-wider {{ !$etkinlik ? '!bg-blue-600' : '!bg-orange-400' }}">
                {{ $etkinlik ? 'Güncelle' : 'Oluştur' }}
            </x-button>
        </div>
    </form>
</section>
