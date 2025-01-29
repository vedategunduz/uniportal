@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    <div class="p-2 bg-blue-700 text-white mb-8 flex space-x-2 items-center justify-between rounded">
        <h4>Kullanıcı yönetimi</h4>
        <div class="flex item-center">
            <select name="isletmeler_id" id="isletmeChange" @class([
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-72 px-2.5 py-1',
                'hidden' => count($isletmeler) <= 1,
            ])>
                @foreach ($isletmeler as $rowIsletme)
                    <option value="{{ encrypt($rowIsletme->isletmeler_id) }}">{{ $rowIsletme->baslik }}</option>
                @endforeach
            </select>
            <button type="button"
                class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white ms-2 open-modal birimDuzenle"
                data-modal="birimDetay" data-id="{{ encrypt(0) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="pointer-events-none">
                    Davet gönder
                </span>
                <a href=""></a>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="kullanicilar" class="display nowrap stripe">
            <thead>
                <tr>
                    <th class="">Personel</th>
                    <th>Çalıştığı Birimler</th>
                    <th class="w-4"></th>
                    <th class="w-4"></th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const modal = document.querySelector('#modal');
            const modal_content = document.querySelector('#modal-content');
            const isletmeSelectElement = document.getElementById('isletmeChange');
            const dataTableName = '#kullanicilar';

            // Sayfa yüklendiğinde mevcut değeri al ve tabloyu oluştur
            let isletmeler_id = isletmeSelectElement.value;

            async function sendForm(url, form) {
                const formData = new FormData(form);

                const RESPONSE_DATA =
                    await fetchData(url, formData, true);

                if (RESPONSE_DATA.success) {
                    successAlert(RESPONSE_DATA.message);
                    $(dataTableName).DataTable().ajax.reload(null, false);
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                } else {
                    errorAlert(RESPONSE_DATA.message);
                }
            }

            getDataTableDatas(dataTableName, `api/yonetim/kullanicilar/show/${isletmeler_id}`);

            // Değer değiştiğinde tabloyu güncelle
            isletmeSelectElement.addEventListener('change', () => {
                // Yeni değeri al
                isletmeler_id = isletmeSelectElement.value;

                // Önceki DataTable'ı yok et ve yenisini oluştur
                $(dataTableName).DataTable().destroy();
                getDataTableDatas(dataTableName, `api/yonetim/kullanicilar/show/${isletmeler_id}`);
            });

            document.addEventListener('change', async (e) => {
                if (e.target.matches('.unvanDegistir')) {
                    const formData = new FormData();

                    formData.append('kullanicilar_id', e.target.dataset.kullanicilarId);
                    formData.append('isletme_birimleri_id', e.target.dataset.birimId);
                    formData.append('unvanlar_id', e.target.value);

                    const RESPONSE_DATA =
                        await fetchData(`api/yonetim/kullanicilar/unvan-degistir`, formData, true);

                    if (RESPONSE_DATA.success) {
                        successAlert(RESPONSE_DATA.message);
                        $(dataTableName).DataTable().ajax.reload(null, false);

                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                }
            });

            document.addEventListener('click', async (e) => {
                if (e.target.matches('.open-modal')) {
                    // Kullanici silme modalı
                    if (e.target.dataset.eventType == 'deleteModalForKullanici') {
                        const formData = new FormData();

                        formData.append('kullanicilar_id', e.target.dataset.id);
                        formData.append('isletmeler_id', isletmeler_id);

                        const RESPONSE_DATA =
                            await fetchData(`api/modal/kullanicilar/`, formData, true);

                        if (RESPONSE_DATA.success) {
                            modal_content.innerHTML = RESPONSE_DATA.html;
                        } else {
                            errorAlert('Modal içeriği yüklenirken bir hata oluştu.');
                        }
                    }
                    // Birimden çıkartma modalı
                    if (e.target.dataset.eventType == 'deleteModalForBirimdenCikart') {
                        const formData = new FormData();

                        formData.append('kullanicilar_id', e.target.dataset.id);
                        formData.append('isletme_birimleri_id', e.target.dataset.birimId);

                        const RESPONSE_DATA =
                            await fetchData(`api/modal/kullanicilar/birimden-cikart`, formData,
                                true);

                        if (RESPONSE_DATA.success) {
                            modal_content.innerHTML = RESPONSE_DATA.html;
                        } else {
                            errorAlert('Modal içeriği yüklenirken bir hata oluştu.');
                        }
                    }

                    if (e.target.dataset.eventType == 'kullaniciDuzenle') {

                        const RESPONSE_DATA =
                            await fetchData(
                                `api/modal/kullanicilar/detay/${e.target.dataset.id}`);

                        if (RESPONSE_DATA.success) {
                            modal_content.innerHTML = RESPONSE_DATA.html;
                        } else {
                            errorAlert('Modal içeriği yüklenirken bir hata oluştu.');
                        }
                    }
                }
                if (e.target.matches('.deleteKullaniciForIsletmeSubmit')) {
                    e.preventDefault();
                    sendForm('api/yonetim/kullanicilar/sil', e.target.closest('form'));
                }
                if (e.target.matches('.deleteKullaniciForIsletmeBirimSubmit')) {
                    e.preventDefault();
                    sendForm('api/yonetim/kullanicilar/birimden-cikart', e.target.closest('form'));
                }
                if (e.target.matches('.updateKullaniciSubmit')) {
                    e.preventDefault();
                    sendForm('api/yonetim/kullanicilar/duzenle', e.target.closest('form'));
                }
            });
        });
    </script>
@endsection
