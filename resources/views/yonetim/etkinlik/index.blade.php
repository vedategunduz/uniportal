@extends('layouts.auth')

@section('title', 'Etkinlik Yönetimi')

@section('content')
    <header class="flex justify-between items-center mb-4">
        <h4>Etkinlik Yönetimi</h4>
        <button type="button" class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white open-modal"
            data-modal="modal" data-id="{{ encrypt(0) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-5 pointer-events-none">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span class="pointer-events-none">
                Ekle
            </span>
        </button>
    </header>


    <div id="modal" class="modal hidden">
        <section class="modal-outside close-modal" data-modal="modal"></section>

        <section id="modal-content" class="modal-content max-w-screen-lg rounded-lg"></section>
    </div>
@endsection

@section('scripts')
    <script>
        window.addEventListener('click', function(event) {
            if (event.target.matches('.open-modal')) {
                const modal = document.getElementById(event.target.dataset.modal);
                const modalContent = modal.querySelector('#modal-content');

                const RESPONSE_DATA = fetchData(`api/modal/etkinlik`);

                if (RESPONSE_DATA.success)
                    modalContent.innerHTML = RESPONSE_DATA;
            }
        });
    </script>
@endsection
