@props([
    'id' => uniqid(),
    'isletme',
])

<span data-popover-target="{{ $id }}">{{ $slot }}</span>

<div data-popover id="{{ $id }}" role="tooltip"
    class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
    <div class="p-3">
        <div class="flex items-center justify-between mb-2">
            <a href="#">
                <img class="w-10 h-10 rounded-full" src="{{ asset($isletme->logoUrl) }}" alt="{{ $isletme->baslik }} logo">
            </a>
            <div>
                <x-button
                    class="!bg-indigo-600 hover:!bg-indigo-700 focus:!ring-indigo-500 text-white rounded-full border-none !px-2.5 !py-1.5 !text-xs">
                    Takip et
                </x-button>
            </div>
        </div>
        <p class="text-base font-semibold text-gray-900">
            <a href="#">{{ $isletme->baslik }}</a>
        </p>
        <p class="mb-4 text-sm">
            <a href="{{ $isletme->websiteUrl }}" target="_blank" class="text-blue-500 hover:text-blue-600">
                {{ $isletme->websiteUrl }}
            </a>
        </p>
        <div class="flex items-center space-x-2 mb-4">

            <a href="{{ $isletme->instagramUrl }}" target="_blank"
                class="
                bg-gradient-to-br from-[#405de6] via-[#c13584] to-[#fd1d1d] text-transparent bg-clip-text hover:!text-transparent hover:opacity-80">
                <i class="bi bi-instagram"></i>
            </a>

            <a href="{{ $isletme->instagramUrl }}" target="_blank" class="text-gray-900 hover:text-gray-950">
                <i class="bi bi-twitter-x"></i>
            </a>

            <a href="{{ $isletme->linkedinUrl }}" target="_blank" class="text-blue-500 hover:text-blue-600">
                <i class="bi bi-linkedin"></i>
            </a>
        </div>


        <div class="flex text-sm">
            <div class="me-2">
                <span class="font-semibold text-gray-900">{{ $isletme->personeller->count() }}</span>
                <span>Çalışan</span>
            </div>
            <div>
                <span class="font-semibold text-gray-900">3,758</span>
                <span>Takipçi</span>
            </div>
        </div>
    </div>
    <div data-popper-arrow></div>
</div>
