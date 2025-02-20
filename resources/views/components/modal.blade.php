@props([
    'id' => 'modal',
    'title' => 'Modal Title',
    'zIndex' => '!z-10',
    'visibility' => 'hidden',
])

<section id="{{ $id }}" class="custom-modal {{ $visibility }} {{ $zIndex }}">
    <div class="modal-outside close-modal" data-modal="{{ $id }}"></div>

    <div {{ $attributes->merge(['class' => 'modal-content rounded max-h-screen hidden-scroll']) }}>
        <header class="flex items-center justify-between text-gray-900 px-6 py-2">
            <div>
                <h2 class="font-semibold text-base text-gray-700 tracking-wider uppercase text-nowrap overflow-hidden whitespace-nowrap overflow-ellipsis w-72" title="{{ $title }}"> {{ $title }} </h2>
            </div>
            <x-button class="close-modal border-none !shadow-none hover:!bg-inherit !px-2"
                data-modal="{{ $id }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </x-button>
        </header>

        <section class="px-6 py-2" data-slot>
            {{ $slot }}
        </section>

        <footer class="px-6 py-2">

        </footer>
    </div>
</section>
