{{-- Event type ve data id dinamik olabilir --}}
<button type="button" data-modal="modal" data-id="{{ encrypt($kullanicilar_id) }}" data-event-type="deleteModalForKullanici"
    class="open-modal bg-rose-500 text-white p-2 rounded" title="silme onay kutusunu aç">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-3 pointer-events-none">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
    </svg>
</button>
