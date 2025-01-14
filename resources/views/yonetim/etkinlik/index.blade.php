@extends('layouts.auth')

@section('title', 'Etkinlik Yönetimi')

@section('content')
    <div class="flex justify-between items-center bg-blue-700 text-white mb-8 p-2">
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
    </div>

    <div class="overflow-x-auto">
        <table id="etkinlikler" class="display nowrap stripe">
            <thead>
                <tr>
                    <th class="w-96">Başlık</th>
                    <th data-dt-order="disable">Kontenjan</th>
                    <th>Başvuru tarihi</th>
                    <th>Başvuru bitiş tarihi</th>
                    <th>Başlama tarihi</th>
                    <th>Bitiş tarihi</th>
                    <th data-dt-order="disable"></th>
                    <th data-dt-order="disable"></th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <div id="modal" class="custom-modal hidden">
        <section class="modal-outside close-modal" data-modal="modal"></section>

        <section id="modal-content" class="modal-content max-w-screen-lg rounded max-h-screen overflow-auto hidden-scroll">
        </section>
    </div>
@endsection

@section('scripts')
    <script>
        $('#etkinlikler').DataTable({
            lengthMenu: [20, 40, 100, {
                'label': 'Hepsi',
                'value': -1
            }],
            ajax: {
                url: `{{ route('yonetim.etkinlikler.show') }}`,
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                dataSrc: 'data',
            },
        });
        window.addEventListener('click', function(event) {
            if (event.target.matches('.open-modal')) {
                const modal = document.getElementById(event.target.dataset.modal);
                const modalContent = modal.querySelector('#modal-content');

                (async () => {
                    try {
                        const RESPONSE_DATA = await fetchData(
                            `api/modal/etkinlik/${event.target.dataset.id}`);

                        if (RESPONSE_DATA.success) {
                            modalContent.innerHTML = RESPONSE_DATA.html;
                            // Summernote çalışması için
                            callSummernote('#summernote');
                            // Input file ile seçilen resimlerin önizlemesi
                            callResimler();
                        } else
                            errorAlert('İçerik eklenemedi.');
                    } catch (error) {
                        errorAlert(error.message);
                    }
                })();
            }

            if (event.target.matches('.etkinlikSubmit')) {
                event.preventDefault();
                event.target.disabled = true;

                const form = event.target.closest('form');
                const formData = new FormData(form);

                if (event.target.dataset.eventType == 'insert') {
                    (async () => {
                        try {
                            const RESPONSE_DATA = await fetchData('api/etkinlik/ekle', formData, true)

                            if (RESPONSE_DATA.success) {
                                successAlert(RESPONSE_DATA.message);
                                $('#etkinlikler').DataTable().ajax.reload(null, false);
                                document.getElementById('modal').classList.add('hidden');
                                document.body.classList.remove('overflow-hidden');
                            } else {
                                if (RESPONSE_DATA.errors) {
                                    for (const [key, value] of Object.entries(RESPONSE_DATA.errors)) {
                                        errorAlert(value);
                                    }
                                } else
                                    errorAlert(RESPONSE_DATA.message);

                            }
                            event.target.disabled = false;
                        } catch (error) {
                            errorAlert(error.message);
                            event.target.disabled = false;
                        }
                    })();
                }
            }
        });
    </script>
@endsection
