@props(['id' => 'modal'])

<div id="{{ $id }}" class="custom-modal hidden">
    <section class="modal-outside close-modal" data-modal="{{ $id }}"></section>

    <section id="{{ $id }}-content" class="modal-content max-w-screen-md rounded max-h-screen hidden-scroll">
        {{ $slot }}
    </section>
</div>
