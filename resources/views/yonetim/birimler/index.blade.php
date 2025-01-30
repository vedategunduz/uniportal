@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    <div
        class="p-2 bg-blue-700 text-white mb-4 flex flex-col lg:flex-row lg:space-x-2 lg:items-center justify-between rounded">
        <h4>Birim yönetimi</h4>
        <div class="flex item-center">
            <button type="button" data-modal="modal"
                class="open-modal personelListesi bg-red-500 text-sm pl-2 py-1.5 pr-4 me-2 rounded flex items-center text-white">
                Birime yerleşmemiş kullanıcılar({{ $birimYerlesmemisKullanicilarSayisi }})
            </button>
            <select name="isletmeler_id" id="isletmeChange" @class([
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-72 px-2.5 py-1',
                'hidden' => count($isletmeler) <= 1,
            ])>
                @foreach ($isletmeler as $rowIsletme)
                    <option value="{{ encrypt($rowIsletme->isletmeler_id) }}">{{ $rowIsletme->baslik }}</option>
                @endforeach
            </select>
            <button type="button"
                class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white ms-2 open-modal modalBirimGoster"
                data-modal="modal" data-id="{{ encrypt(0) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="pointer-events-none">
                    Ekle
                </span>
                <a href=""></a>
            </button>
        </div>
    </div>

    <div class="overflow-y-auto">
        <table id="birimler" class="display nowrap stripe" style="width:100%">
            <thead>
                <tr>
                    <th>Birim adı</th>
                    <th data-dt-order="disable">Personel listesi</th>
                    <th class="w-4" data-dt-order="disable"></th>
                    <th class="w-4" data-dt-order="disable"></th>
                </tr>
            </thead>
            <tbody id="tableBody">

            </tbody>
        </table>
    </div>
@endsection


@section('scripts')
    <script>
        const modal = document.querySelector('#modal');
        const modal_content = document.querySelector('#modal-content');
        const isletmeSelectElement = document.getElementById('isletmeChange');
        const dataTableName = '#birimler';
        let isletmeler_id = isletmeSelectElement.value;
        // Değer değiştiğinde tabloyu güncelle

        getDataTableDatas(dataTableName, `yonetim/birimler/${isletmeler_id}`);

        isletmeSelectElement.addEventListener('change', () => {
            // Yeni değeri al
            isletmeler_id = isletmeSelectElement.value;

            // Önceki DataTable'ı yok et ve yenisini oluştur
            $(dataTableName).DataTable().destroy();
            getDataTableDatas(dataTableName, `yonetim/birimler/${isletmeler_id}`);
        });

        $('#birimler').on('draw.dt', function() {
            document.querySelectorAll('[data-popover-target]').forEach(triggerEl => {
                const targetEl = document.getElementById(triggerEl.getAttribute(
                    'data-popover-target'));
                new Popover(targetEl, triggerEl);
            });
        });

        window.addEventListener('click', function(event) {
            if (event.target.matches('.birimDegistir')) {
                const formData = new FormData();
                formData.append('kullanici_birim_unvan_iliskileri_id', event.target.dataset.id);
                formData.append('isletmeler_id', isletmeSelectElement.value);

                (async () => {
                    const RESPONSE_DATA = await fetchData(
                        `yonetim/birimler/birimDegistirmeModalContent`, formData, true);

                    if (RESPONSE_DATA.success) {
                        modal_content.innerHTML = RESPONSE_DATA.html;
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                })();
            }

            if (event.target.matches('.birimSil')) {
                (async function() {
                    const RESPONSE_DATA = await fetchData(
                        `yonetim/birimler/silmeModalContent/${event.target.dataset.id}/`);

                    if (RESPONSE_DATA.success) {
                        modal_content.innerHTML = RESPONSE_DATA.html;
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                })();
            }

            if (event.target.matches('.modalBirimGoster')) {
                (async function() {
                    const birimler_id = event.target.dataset.id;

                    const RESPONSE_DATA = await fetchData(
                        `yonetim/birimler/modalBirimGoster/${birimler_id}`
                    );

                    if (RESPONSE_DATA.success) {
                        modal_content.innerHTML = RESPONSE_DATA.html;
                        modalPersonelListesiGuncelle(birimler_id);
                    } else {
                        errorAlert('Kayıt gösterilemedi.');
                    }
                })();
            }

            if (event.target.matches('.birimePersonelAtaSubmit')) {
                event.preventDefault();

                (async function() {
                    const form = event.target.closest('form');
                    const formData = new FormData(form);
                    const RESPONSE_DATA = await fetchData('yonetim/birimler/personelBirimAta', formData,
                        true);

                    if (RESPONSE_DATA.success) {
                        $('#birimler').DataTable().ajax.reload(null, false);
                        successAlert(RESPONSE_DATA.message);
                        birimeYerlesmemisPersonelSayisiGetir();
                        birimYerlesmemisPersonelContainerGuncelle();
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                })();
            }

            if (event.target.matches('.personelleriBirimeEkle')) {
                (async function() {
                    // FormData nesnesi oluşturma
                    const formData = new FormData();

                    formData.append('isletme_birimleri_id', document.querySelector(
                        'input[name=search_birimler_id]').value);

                    // Doğru adlandırma ve tırnaklama ile checkbox seçimi
                    const checkboxes = document.querySelectorAll(
                        'input[name="eklenecekPersoneller[]"]:checked');

                    // Seçili her checkbox için formData'ya değer ekleme
                    checkboxes.forEach((checkbox) => {
                        formData.append('kullanicilar[]', checkbox.value);
                    });

                    const RESPONSE_DATA = await fetchData('yonetim/birimler/personelBirimAta', formData,
                        true);

                    if (RESPONSE_DATA.success) {
                        $('#birimler').DataTable().ajax.reload(null, false);
                        successAlert(RESPONSE_DATA.message);
                        birimeYerlesmemisPersonelSayisiGetir();
                        modalPersonelListesiGuncelle(Object.fromEntries(formData)['isletme_birimleri_id']);
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                })();
            }

            if (event.target.matches('.birimDetayModalSubmit')) {
                event.preventDefault();
                const form = event.target.closest('form');
                const formData = new FormData(form);
                formData.append('isletmeler_id', isletmeSelectElement.value);

                if (event.target.dataset.buttonType === 'duzenle') {
                    (async () => {
                        const RESPONSE_DATA = await fetchData('yonetim/birimler/birimGuncelle', formData,
                            true);

                        if (RESPONSE_DATA.success) {
                            $('#birimler').DataTable().ajax.reload(null, false);
                            successAlert(RESPONSE_DATA.message);
                            modal.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        } else {
                            errorAlert(RESPONSE_DATA.message);
                        }
                    })();
                } else {
                    (async () => {
                        const isletmeler_id = isletmeSelectElement.value;

                        const RESPONSE_DATA = await fetchData(
                            `yonetim/birimler/birimEkle/${isletmeler_id}`,
                            formData,
                            true);

                        if (RESPONSE_DATA.success) {
                            $('#birimler').DataTable().ajax.reload(null, false);
                            successAlert(RESPONSE_DATA.message);
                            modal.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        } else {
                            errorAlert(RESPONSE_DATA.message);
                        }
                    })();
                }
            }

            if (event.target.matches('.birimSilmeFormSubmit')) {
                event.preventDefault();
                const form = event.target.closest('form');
                const formData = new FormData(form);

                (async function() {
                    const RESPONSE_DATA = await fetchData('yonetim/birimler/sil', formData, true)

                    if (RESPONSE_DATA.success) {
                        $('#birimler').DataTable().ajax.reload(null, false);
                        successAlert(RESPONSE_DATA.message);
                        birimeYerlesmemisPersonelSayisiGetir();
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                })();
            }

            if (event.target.matches('.birimDegistirFormSubmit')) {
                event.preventDefault();

                const form = event.target.closest('form');
                const formData = new FormData(form);
                (async () => {
                    const RESPONSE_DATA = await fetchData('yonetim/birimler/personelBirimDegistir',
                        formData,
                        true)

                    if (RESPONSE_DATA.success) {
                        $('#birimler').DataTable().ajax.reload(null, false);
                        successAlert(RESPONSE_DATA.message);
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                })();
            }

            if (event.target.matches('.personelListesi')) {
                const isletmeler_id = isletmeSelectElement.value;
                const formData = new FormData();
                formData.append('isletmeler_id', isletmeler_id);

                (async function() {
                    const RESPONSE_DATA = await fetchData(
                        `yonetim/birimler/birimeYerlesmemisPersonelModalContent`,
                        formData,
                        true
                    );

                    if (RESPONSE_DATA.success) {
                        modal_content.innerHTML = RESPONSE_DATA.html;
                        birimYerlesmemisPersonelContainerGuncelle();
                        // modalPersonelListesiGuncelle(birimler_id);
                    } else {
                        errorAlert('Kayıt gösterilemedi.');
                    }
                })();
            }
        });

        async function birimYerlesmemisPersonelContainerGuncelle () {
            const formData = new FormData();
            formData.append('isletmeler_id', isletmeSelectElement.value);

            const RESPONSE_DATA = await fetchData('yonetim/birimler/birimeYerlesmemisPersoneller', formData, true);

            if (RESPONSE_DATA.success) {
                document.getElementById('birimeYerlesmemisPersonelContainer').innerHTML = RESPONSE_DATA.html;
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        }

        document.addEventListener('input', function(event) {
            const target = event.target.closest('#default-search');
            if (!target) return;

            const searchValue = target.value;
            const personelEklemeListesi = document.getElementById('personelEklemeListesi');

            async function search() {
                try {
                    const birimler_id = document.querySelector('input[name=search_birimler_id]').value;
                    const RESPONSE_DATA = await fetchData(
                        `yonetim/birimler/personelEklemeListesi/${birimler_id}/${searchValue}`);

                    if (RESPONSE_DATA.success) {
                        personelEklemeListesi.innerHTML = RESPONSE_DATA.html;
                    } else {
                        errorAlert(RESPONSE_DATA.message);
                    }
                } catch (error) {
                    errorAlert(`Bir hata oluştu. Lütfen daha sonra tekrar deneyin. ${error}`);
                }
            }

            if (searchValue.length >= 2) {
                search();
            } else {
                personelEklemeListesi.innerHTML = '';
            }
        });

        async function birimeYerlesmemisPersonelSayisiGetir() {
            const isletmeler_id = isletmeSelectElement.value;

            const RESPONSE_DATA = await fetchData(`yonetim/birimler/birimeYerlesmemisPersonelSayisi/${isletmeler_id}`);

            if (RESPONSE_DATA.success) {
                const button = document.querySelector('button.personelListesi');
                if (button) {
                    button.textContent = `Birime yerleşmemiş personeller(${RESPONSE_DATA.message})`;
                }
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        }
        birimeYerlesmemisPersonelSayisiGetir();

        async function modalPersonelListesiGuncelle(id) {
            const RESPONSE_DATA = await fetchData(`yonetim/birimler/modal/birimKullanicilari/${id}`);

            if (RESPONSE_DATA.success) {
                document.getElementById('personeller').innerHTML = RESPONSE_DATA.html;

                document.querySelectorAll('[data-popover-target]').forEach(triggerEl => {
                    const targetEl = document.getElementById(triggerEl.getAttribute(
                        'data-popover-target'));
                    new Popover(targetEl, triggerEl);
                });
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        }

        async function birimdenCikart(id, birimId) {
            const RESPONSE_DATA = await fetchData(`yonetim/birimler/birimPersonelSil/${id}`);
            birimeYerlesmemisPersonelSayisiGetir();

            if (RESPONSE_DATA.success) {
                $('#birimler').DataTable().ajax.reload(null, false);
                successAlert(RESPONSE_DATA.message);
                if (birimId != 0) {
                    modalPersonelListesiGuncelle(birimId);
                }
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        }
    </script>
@endsection
