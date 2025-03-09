@extends('layouts.auth')

@section('title', 'Etkinlik Yönetimi')

@section('content')
    <div class="flex justify-between items-center bg-blue-700 text-white mb-8 p-2 rounded">
        <h4>Etkinlik Yönetimi</h4>
        <div class="flex items-center gap-4">
            <select name="isletmeler_id" id="isletmeChange" @class([
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-72 px-2.5 py-1',
                'hidden' => count($isletmeler) <= 1,
            ])>
                @foreach ($isletmeler as $rowIsletme)
                    <option value="{{ encrypt($rowIsletme->isletmeler_id) }}">{{ $rowIsletme->baslik }}</option>
                @endforeach
            </select>
            <x-button class="bg-emerald-500 open-modal"
                data-modal="modal" data-id="{{ encrypt(0) }}" data-event-type="insert">
                Ekle
            </x-button>
        </div>
    </div>

    <div class="w-full overflow-x-auto">
        <table id="etkinlikler" class="display nowrap stripe">
            <thead>
                <tr>
                    <th>Başlık</th>
                    <th>Başvuru tarihleri</th>
                    <th>Başlama tarihleri</th>
                    <th data-dt-order="disable"></th>
                    <th data-dt-order="disable"></th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script>
        function verileriGetir(isletmeler_id) {
            $('#etkinlikler').DataTable({
                responsive: true,
                ordering: false,
                lengthMenu: [20, 40, 100, {
                    'label': 'Hepsi',
                    'value': -1
                }],
                ajax: {
                    url: `etkinlikler/show/${isletmeler_id}`,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    dataSrc: 'data',
                },
            });
        }

        // Ortak fonksiyon
        async function handleEtkinlikForm(eventType, formData, button) {
            try {
                let url = '';
                // İşlem tipine göre url belirliyoruz
                switch (eventType) {
                    case 'insert':
                        url = 'yonetim/etkinlikler/ekle';
                        break;
                    case 'update':
                        url = 'yonetim/etkinlikler/guncelle';
                        break;
                    case 'delete':
                        url = 'yonetim/etkinlikler/sil';
                        break;
                    default:
                        errorAlert('Bir hata oluştu.');
                        return;
                }

                const RESPONSE_DATA = await fetchData(url, formData, true);

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
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                }
            } catch (error) {
                errorAlert(error.message);
            } finally {
                // İster başarılı ister hatalı olsun, buton kilidini açıyoruz
                button.disabled = false;
                if (eventType == 'insert')
                    button.textContent = 'Oluştur';
                else
                    button.textContent = 'Güncelle';
            }
        }

        window.addEventListener('click', function(event) {
            if (event.target.matches('.open-modal')) {
                const modal = document.getElementById(event.target.dataset.modal);
                const modalContent = modal.querySelector('#modal-content');

                if (event.target.dataset.eventType == 'insert' || event.target.dataset.eventType == 'update') {
                    (async () => {
                        try {
                            const RESPONSE_DATA = await fetchData(
                                `yonetim/etkinlikler/modalGetir/${event.target.dataset.id}`);

                            if (RESPONSE_DATA.success) {
                                modalContent.innerHTML = RESPONSE_DATA.html;
                                // Summernote çalışması için
                                callSummernote('#summernote');
                                // Input file ile seçilen resimlerin önizlemesi
                                callResimler();
                            } else
                                errorAlert('Bir hata oluştu.');
                        } catch (error) {
                            errorAlert(error.message);
                        }
                    })();
                }

                if (event.target.dataset.eventType == 'delete') {
                    (async () => {
                        try {
                            const RESPONSE_DATA = await fetchData(
                                `yonetim/etkinlikler/silmeModalGetir/${event.target.dataset.id}`);

                            if (RESPONSE_DATA.success) {
                                modalContent.innerHTML = RESPONSE_DATA.html;
                            } else
                                errorAlert('Bir hata oluştu.');
                        } catch (error) {
                            errorAlert(error.message);
                        }
                    })();
                }
            }

            if (event.target.matches('.etkinlik-submit')) {
                event.preventDefault();

                const button = event.target;
                const eventType = button.dataset.eventType;
                const form = event.target.closest('form');
                const formData = new FormData(form);

                button.disabled = true;
                button.textContent = 'Bekleyiniz...';
                handleEtkinlikForm(eventType, formData, event.target);
            }

            if (event.target.matches('.galeri-resmi-kaldir')) {
                console.log(event.target.dataset.id);
                (async () => {
                    try {
                        const RESPONSE_DATA = await fetchData(
                            `yonetim/etkinlikler/resmi-kaldir/${event.target.dataset.id}`);

                        if (RESPONSE_DATA.success) {
                            event.target.closest('.galeri-resmi').remove();
                        } else
                            errorAlert('Resim kaldırılamadı.');
                    } catch (error) {
                        errorAlert(error.message);
                    }
                })();
            }
        });


        document.addEventListener('DOMContentLoaded', function() {
            verileriGetir(document.getElementById('isletmeChange').value);
        });

        document.getElementById('isletmeChange').addEventListener('change', function() {
            $('#etkinlikler').DataTable().destroy();
            verileriGetir(this.value);
        });
    </script>
@endsection
