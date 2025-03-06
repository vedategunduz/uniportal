@php
    use Carbon\Carbon;

    $start = Carbon::parse($etkinlik->etkinlikBaslamaTarihi);
    $end = Carbon::parse($etkinlik->etkinlikBitisTarihi);

    // Örnek olarak, ay ve yıl aynıysa sadece günleri birleştiriyoruz.
    // Ardından tek bir metin oluşturuyoruz.
    $gunBaslama = $start->translatedFormat('d'); // 05
    $gunBitis = $end->translatedFormat('d'); // 06
    $ay = $start->translatedFormat('M'); // Mar
    $yil = $start->translatedFormat('Y'); // 2025
    $saat = $start->translatedFormat('H:i'); // 03:07 (24 saat formatında)

    $tarihAraligi = "{$gunBaslama}-{$gunBitis} {$ay}, {$yil}, {$saat}";
    // Sonuç: "05-06 Mar, 2025, 03:07"

    $start = Carbon::parse($etkinlik->etkinlikBasvuruBaslamaTarihi);
    $end = Carbon::parse($etkinlik->etkinlikBasvuruBitisTarihi);

    $gunBaslama = $start->translatedFormat('d'); // 05
    $gunBitis = $end->translatedFormat('d'); // 06
    $ay = $start->translatedFormat('M'); // Mar
    $yil = $start->translatedFormat('Y'); // 2025
    $saat = $start->translatedFormat('H:i'); // 03:07 (24 saat formatında)

    $tarihAraligi2 = "{$gunBaslama}-{$gunBitis} {$ay}, {$yil}, {$saat}";

@endphp

<section class="w-full p-4 sm:p-6 space-y-6 bg-gray-50 text-gray-800 rounded-md shadow">

    <!-- Kapak Fotoğrafı -->
    <div class="relative">
        <img class="w-full h-48 object-cover rounded-md" src="{{ $etkinlik->kapakResmiYolu }}"
            alt="Etkinlik Kapak Fotoğrafı">
        {{-- <div class="absolute bottom-2 left-2 bg-black bg-opacity-60 text-white px-3 py-1 rounded">
            <h2 class="font-bold text-lg sm:text-xl">
                {{ $etkinlik->baslik }}
            </h2>
        </div> --}}
    </div>

    <h2 class="font-bold text-lg sm:text-xl">
        {{ $etkinlik->baslik }}
    </h2>

    <!-- Düzenleyen Kurum Bilgisi -->
    <div class="flex items-center">
        <!-- Kurum Logosu (opsiyonel) -->
        <img class="w-12 h-12 rounded-full object-cover mr-3" src="{{ $etkinlik->isletme->logoUrl }}"
            alt="Organizasyon Logo">
        <div>
            <p class="font-semibold text-gray-800">
                Düzenleyen: <span class="font-normal text-gray-700">{{ $etkinlik->isletme->baslik }}</span>
            </p>
            {{-- <p class="text-sm text-gray-600">Teknoloji topluluğu etkinlikleri</p> --}}
        </div>
    </div>

    <!-- Tarih Alanları -->
    <div class="grid gap-4">
        <!-- Başvuru Tarihi -->
        <div class="bg-white p-4 rounded-md shadow-sm">
            <div class="flex items-center mb-1">
                <i class="bi bi-clock-history text-gray-600"></i>
                <span class="ml-2 font-medium text-gray-700">Başvuru Tarihi</span>
            </div>
            <p class="ml-6 text-sm text-gray-700">
                {{ $tarihAraligi }}
                {{-- "05-06 Mar, 2025, 03:07" --}}
            </p>
        </div>

        <!-- Etkinlik Tarihi -->
        <div class="bg-white p-4 rounded-md shadow-sm">
            <div class="flex items-center mb-1">
                <i class="bi bi-calendar-event text-gray-600"></i>
                <span class="ml-2 font-medium text-gray-700">Etkinlik Tarihi</span>
            </div>
            <p class="ml-6 text-sm text-gray-700">
                {{ $tarihAraligi2 }}
                {{-- "07-08 Mar, 2025, 03:07" --}}
            </p>
        </div>
    </div>

    <!-- Katılım Şartları -->
    <div class="p-4 bg-gray-100 rounded-md">
        <h3 class="text-lg font-bold mb-2 text-gray-800">Katılım Şartları</h3>
        {{-- <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
            <li>18 yaşından büyük olmak</li>
            <li>Ön kayıt formunu doldurmak</li>
            <li>Katılım ücreti (varsa) ödenmiş olmak</li>
            <li>Etkinlik kurallarına uyum sağlamak</li>
        </ul> --}}
        <p class="text-sm text-gray-700">
            {{ $etkinlik->katilimSarti }}
        </p>
    </div>

    <!-- Butonlar -->
    <form action="{{ route('etkinlikler.katil.store', ['etkinlik_id' => encrypt($etkinlik->etkinlikler_id)]) }}"
        class="space-y-4">
        <x-textarea rows="3" name="aciklama" placeholder="Açıklama (opsiyonel)"></x-textarea>

        <x-checkbox name="katilimSartlari" id="katilimSartlari" class="text-sm">
            Katılım şartlarını ve iletişim bilgilerimin düzenleyen kurum/işletme yetkilisiyle paylaşılmasını kabul
            ediyorum.
        </x-checkbox>

        <x-button type="submit" class="etkinlik-katil-submit-button w-full justify-center !bg-green-400 !text-white">
            Katıl
        </x-button>
    </form>
</section>
