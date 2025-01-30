<header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t">
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

<div class="ozelBoyut"></div>

<section class="p-6">

    @if (!empty($mailler))
        <p>Geçerli Mailler</p>
        <p class="text-xs"><strong>*</strong> Aşağıdaki mailler geçerlidir.</p>
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
</section>
