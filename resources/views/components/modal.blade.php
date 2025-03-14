@props([
    'id' => 'modal',
    'title' => 'Modal Title',
    'zIndex' => '!z-20',
    'visibility' => 'hidden',
    'slotClass' => 'px-6 py-2 mb-2',
    'headerClass' => '',
    'headerCloseButton' => true
])

<section id="{{ $id }}" class="custom-modal {{ $visibility }} {{ $zIndex }}">
    <div class="modal-outside close-modal" data-modal="{{ $id }}"></div>

    <div {{ $attributes->merge(['class' => 'modal-content rounded max-h-screen hidden-scroll']) }}>
        <header class="flex items-center rounded-t bg-blue-500 text-white justify-between px-6 py-2 {{ $headerClass }}">
            <div>
                <h2 class="font-semibold text-base tracking-wider uppercase text-nowrap text-inherit overflow-hidden whitespace-nowrap overflow-ellipsis w-72"
                    title="{{ $title }}"> {{ $title }} </h2>
            </div>
            @if ($headerCloseButton === true)
                <x-button class="close-modal border-none text-inherit !bg-transparent !shadow-none !px-2"
                    data-modal="{{ $id }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </x-button>
            @endif
        </header>

        <section class="{{ $slotClass }}" data-slot>
            {{ $slot }}
        </section>
    </div>
</section>
