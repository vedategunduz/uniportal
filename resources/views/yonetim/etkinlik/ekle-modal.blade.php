<section>
    <x-modal id="imageCropModal" class="sm:w-2/4" title="Kırp">
        <div class="relative h-96">
            <img id="image" class="max-w-full" alt="Yüklenecek görüntü">
        </div>
        <x-button id="cropButton" class="mt-4">
            Kırp
        </x-button>
    </x-modal>

    <form
        action="{{ $etkinlik ? route('yonetim.etkinlikler.update', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) : route('yonetim.etkinlikler.store') }}"
        method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        @if ($etkinlik)
            @method('PATCH')
        @endif

        <div class="flex flex-col gap-4 shadow p-4 rounded">
            <div class="mb-4 relative">
                <img id="banner-image" src="{{ optional($etkinlik)->kapakResmiYolu ?? asset('image/resim-yok.png') }}"
                    class="max-h-96 w-full object-contain rounded" loading="lazy" alt="">

                <div class="absolute top-4 left-4">
                    <label for="inputImage"
                        class="inline-flex items-center px-4 py-2.5 bg-white border border-gray-300 rounded font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-gray-50 text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:text-gray-500 disabled:hover:!bg-inherit transition ease-in-out duration-150 cursor-pointer">
                        Kapak resmi değiştir
                    </label>
                </div>
            </div>
            <input type="file" id="inputImage" name="kapakResmiYolu" class="hidden" accept="image/*">

            <select name="isletmeler_id" @class(['w-full border border-gray-300 rounded py-1.5'])>
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

            <x-relative-input type="text" name="baslik" label="Etkinlik başlığı"
                value="{{ optional($etkinlik)->baslik }}" required />

            <div class="grid grid-cols-3 gap-2">
                <select name="etkinlik_turleri_id" @class(['w-full border border-gray-300 rounded py-1.5'])>
                    <option value="">Kategori seçiniz</option>
                    @foreach ($kategoriler as $kategori)
                        <option value="{{ encrypt($kategori->etkinlik_turleri_id) }}"
                            {{ $etkinlik && $etkinlik->etkinlik_turleri_id == $kategori->etkinlik_turleri_id ? 'selected' : '' }}>
                            {{ $kategori->baslik }}
                        </option>
                    @endforeach
                </select>

                <select name="iller_id" @class(['w-full border border-gray-300 rounded py-1.5'])>
                    <option value="">Düzenlendiği il</option>
                    @foreach ($iller as $il)
                        <option value="{{ encrypt($il->iller_id) }}"
                            {{ $etkinlik && $etkinlik->iller_id == $il->iller_id ? 'selected' : '' }}>
                            {{ $il->baslik }}
                        </option>
                    @endforeach
                </select>

                <x-relative-input type="text" name="kontenjan" label="Kontenjan"
                    value="{{ optional($etkinlik)->kontenjan }}" required />
            </div>

            <div class="grid sm:grid-cols-2 gap-2">
                <x-datetime name="etkinlikBasvuruTarihi" label="Başvuru tarihi"
                    value="{{ optional($etkinlik)->etkinlikBaslamaTarihi }}" />

                <x-datetime name="etkinlikBasvuruBitisTarihi" label="Başvuru bitiş tarihi"
                    value="{{ optional($etkinlik)->etkinlikBitisTarihi }}" />

                <x-datetime name="etkinlikBaslamaTarihi" label="Başlama tarihi"
                    value="{{ optional($etkinlik)->etkinlikBaslamaTarihi }}" />

                <x-datetime name="etkinlikBitisTarihi" label="Bitiş tarihi"
                    value="{{ optional($etkinlik)->etkinlikBitisTarihi }}" />
            </div>

            <x-file-upload text="/Resim veya Dosya seç ya da buraya bırak" />
        </div>

        <div class="flex flex-col gap-4 shadow p-4 rounded">
            <p class="text-lg font-medium text-gray-900 mb-0">Katılım Şartları</p>
            <textarea name="katilimSarti" id="katilisimSartiSummernote">{{ optional($etkinlik)->katilimSarti }}</textarea>

            <p class="text-lg font-medium text-gray-900 mb-0">Etkinlik Açıklaması</p>
            <textarea name="aciklama" id="aciklamaSummernote">{{ optional($etkinlik)->aciklama }}</textarea>

            <p class="text-lg font-medium text-gray-900 border-b border-t py-2">Etkinlik İzinleri</p>

            <x-checkbox name="yorumDurumu" :checked="optional($etkinlik)->yorumDurumu">
                <span>Yorumlara kapat</span>
                <span class="text-gray-500 font-normal text-xs">Etkinliği yoruma kapatmak için seçiniz.</span>
            </x-checkbox>

            <x-checkbox name="sosyalMedyadaPaylas" :checked="optional($etkinlik)->sosyalMedyadaPaylas">
                <span>Sosyal medyamızda paylaş</span>
                <span class="text-gray-500 font-normal text-xs">
                    Etkinliği sosyal medya hesabımızda paylaşılması için seçiniz.</span>
            </x-checkbox>

            <x-checkbox name="mailDurumu" :checked="optional($etkinlik)->mailDurumu">
                <span>Mail bildirimleri almak istiyorum</span>
                <span class="text-gray-500 font-normal text-xs">
                    Katılım isteklerini mail ile almak için seçiniz.
                </span>
            </x-checkbox>

            <div class="text-right">
                <x-button type="submit" @class([
                    'etkinlik-submit-button justify-center w-full !border-none !text-white !tracking-wider',
                    '!bg-blue-600' => !$etkinlik,
                    '!bg-orange-400' => $etkinlik,
                ])>
                    {{ $etkinlik ? 'Güncelle' : 'Yayınla' }}
                </x-button>
            </div>
        </div>

    </form>
</section>
