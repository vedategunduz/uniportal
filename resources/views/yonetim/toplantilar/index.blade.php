@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    {{-- 13 --}}
    <div class="flex justify-between items-center bg-blue-700 text-white mb-8 p-2 rounded">
        <h4>Ziyaret Yönetimi</h4>
        <div class="flex items-center gap-4">
            <select name="isletmeler_id" id="isletmeler_select" @class([
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-72 px-2.5 py-1',
                'hidden' => count($isletmeler) <= 1,
            ])>
                @foreach ($isletmeler as $rowIsletme)
                    <option value="{{ encrypt($rowIsletme->isletmeler_id) }}">{{ $rowIsletme->baslik }}</option>
                @endforeach
            </select>
            <button type="button"
                class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white open-modal"
                data-modal="modal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="pointer-events-none">
                    Ziyaret Oluştur
                </span>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table id="toplantilar" class="display nowrap stripe">
            <thead>
                <tr>
                    <th class="">Başlık</th>
                    <th class="">Ekip</th>
                    <th class="">Tarih</th>
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
            const isletmeler_select = document.querySelector('#isletmeler_select');

            getDataTableDatas('#toplantilar', `api/yonetim/toplantilar/${isletmeler_select.value}`);

            async function getModal() {
                const RESPONSE_DATA =
                    await fetchData('api/modal/toplantilar/ziyaret/talep');

                if (RESPONSE_DATA.success) {
                    modal_content.innerHTML = RESPONSE_DATA.html;
                } else {
                    errorAlert(RESPONSE_DATA.message);
                }
            }
            await getModal();

            const submit = document.querySelector('button[type="submit"]');

            // Ziyaret Ekibi
            let selectedGidenPersonelEmails = [];
            const SELECTED_PERSONEL = document.querySelector('#selectedPersonel');
            const CREATED_ISLETME = document.querySelector('#olusturan_isletmeler_id');
            const SEARCH = document.querySelector('#search');
            const PERSONEL_COTAINER = document.querySelector('#gidecekPersoneller');

            // Gidilen Kurum
            let selectedGidilecekPersonelEmails = [];
            const OTHER_SEARCH = document.querySelector('#otherSearch');
            const ISLETME = document.querySelector('#gidilen_isletmeler_id');
            const ARAMA_CONTAINER = document.querySelector('#gidilecekPersoneller');
            const SELECTED_GIDILECEK_PERSONEL = document.querySelector('#selectedGidilecekPersonel');

            async function createPersonelCard(id, list, container, isDavetci = false) {
                const formData = new FormData();
                formData.append('kullanicilar_id', id);

                let URL = 'api/modal/toplantilar/ziyaret/talep/personel-card';


                if (isDavetci) {
                    URL += '/davetci';
                }

                const RESPONSE_DATA = await fetchData(URL, formData, true);

                if (RESPONSE_DATA.success) {
                    container.innerHTML += RESPONSE_DATA.html;
                    list.push(RESPONSE_DATA.email);
                } else {
                    errorAlert(RESPONSE_DATA.message);
                }
            }
            await createPersonelCard('{{ encrypt(Auth::user()->kullanicilar_id) }}',
                selectedGidenPersonelEmails, SELECTED_PERSONEL);

            async function getPersonel() {
                const formData = new FormData();

                formData.append('isletmeler_id', CREATED_ISLETME.value);
                formData.append('search', SEARCH.value);
                selectedGidenPersonelEmails.forEach(item => formData.append('searchNot[]', item));

                const RESPONSE_DATA =
                    await fetchData('api/modal/toplantilar/ziyaret/talep/personeller', formData, true);

                if (RESPONSE_DATA.success) {
                    PERSONEL_COTAINER.innerHTML = RESPONSE_DATA.html;

                    const checkboxes = PERSONEL_COTAINER.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', () => {
                            if (checkbox.checked) {
                                createPersonelCard(checkbox.value,
                                    selectedGidenPersonelEmails, SELECTED_PERSONEL);
                                checkbox.closest('.flex').remove();
                            }
                        });

                        if (selectedGidenPersonelEmails.includes(checkbox.dataset.email)) {
                            checkbox.checked = true;
                        }
                    });
                } else
                    errorAlert(RESPONSE_DATA.message);
            }

            async function getYonetici() {
                const formData = new FormData();

                formData.append('isletmeler_id', ISLETME.value);
                formData.append('search', OTHER_SEARCH.value);

                const RESPONSE_DATA =
                    await fetchData('api/modal/toplantilar/ziyaret/talep/personeller/yonetici', formData,
                        true);

                if (RESPONSE_DATA.success) {
                    ARAMA_CONTAINER.innerHTML = RESPONSE_DATA.html;

                    const checkboxes = ARAMA_CONTAINER.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', () => {
                            if (checkbox.checked) {
                                createPersonelCard(checkbox.value,
                                    selectedGidilecekPersonelEmails,
                                    SELECTED_GIDILECEK_PERSONEL, true);
                                checkbox.closest('.flex').remove();
                            }
                        });

                        if (selectedGidilecekPersonelEmails.includes(checkbox.dataset.email)) {
                            checkbox.checked = true;
                        }
                    });
                } else
                    errorAlert(RESPONSE_DATA.message);
            }

            CREATED_ISLETME.addEventListener('change', async () => {
                await getPersonel();
            });

            submit.addEventListener('click', async (e) => {
                e.preventDefault();
                submit.disabled = true;
                try {
                    const formData = new FormData(submit.closest('form'));

                    console.log(Object.fromEntries(formData));

                    const RESPONSE_DATA = await fetchData(
                        'api/modal/toplantilar/ziyaret/talep/olustur',
                        formData, true);

                    if (RESPONSE_DATA.success) {
                        successAlert(RESPONSE_DATA.message);
                        modal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                        $('#toplantilar').DataTable().ajax.reload(null, false);
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

                } finally {
                    submit.disabled = false;
                }
            })

            ISLETME.addEventListener('change', async () => {
                if (ISLETME.value != "") {
                    ISLETME.nextElementSibling.disabled = false;
                    ISLETME.nextElementSibling.placeholder = "Ara...";
                } else {
                    ISLETME.nextElementSibling.disabled = true;
                    ISLETME.nextElementSibling.placeholder = "Kurum seçiniz";
                }
            });

            SEARCH.addEventListener('input', async () => {
                if (SEARCH.value.length < 3) {
                    PERSONEL_COTAINER.innerHTML = '';
                    return;
                }
                await getPersonel();
            });

            OTHER_SEARCH.addEventListener('input', async () => {
                if (OTHER_SEARCH.value.length < 3) {
                    ARAMA_CONTAINER.innerHTML = '';
                    return;
                }
                await getYonetici();
            })

            SELECTED_PERSONEL.addEventListener('click', function(event) {
                if (event.target.matches('.removeSelectedGidenPersonelEmail')) {
                    event.target.closest('.flex').remove();
                    selectedGidenPersonelEmails = selectedGidenPersonelEmails.filter(
                        email => email !== event.target.dataset.email
                    );
                }
            })

            SELECTED_GIDILECEK_PERSONEL.addEventListener('click', function(event) {
                if (event.target.matches('.removeSelectedDavetPersonelEmail')) {
                    event.target.closest('.flex').remove();
                    selectedGidilecekPersonelEmails = selectedGidilecekPersonelEmails.filter(
                        email => email !== event.target.dataset.email
                    );
                }
            })
        });
    </script>
@endsection
