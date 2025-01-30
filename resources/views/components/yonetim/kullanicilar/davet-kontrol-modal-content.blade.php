<header class="flex items-center justify-between bg-rose-500 text-white px-6 py-3 rounded-t">
    <div>
        <h2 class="font-medium text-lg text-white"> Davet Onay </h2>
    </div>
    <button class="close-modal" data-modal="alert-modal">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-5 pointer-events-none">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
</header>

<div class="lg:w-96"></div>

<section class="p-6">

    @if (!empty($mailler))
        <p>Geçerli Mailler</p>
        <p class="text-sm font-bold"><strong>*</strong> {{ count($mailler) }}
            Adet geçerli mail bulunmuştur ilgili
            kişilere kurumunuza katılım daveti gönderilecektir.
        </p>
        <div class="px-6">
            <ul class="list-disc ">
                @foreach ($mailler as $mail)
                    <li>
                        <p class="text-gray-700">{{ $mail }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="text-gray-700">
            Geçerli mail bulunmamaktadır.
        </div>
    @endif

    {{-- MODAL Standart butonlar --}}
    <footer class="grid grid-cols-2 gap-2 mt-4">
        <button data-modal="alert-modal" type="button"
            class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Vazgeç</button>

        <button type="button" data-modal="alert-modal" @class([
            'davetButton open-modal text-white px-3 py-2 rounded transition focus:ring-4 bg-emerald-500 hover:bg-emerald-800 ring-emerald-300',
        ])>Gönder</button>
    </footer>

</section>
