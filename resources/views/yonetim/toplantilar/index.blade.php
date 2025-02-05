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
                    <th class="">Ziyaret Edilen Kurum</th>
                    <th class="">Ziyaret Başlık</th>
                    <th class="">Tarih</th>
                    <th class="">Ziyaret Eden Kişiler</th>
                    <th class="">Ziyaret Edilen Kişiler</th>
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

            // Ziyaret Ekibi
            let selectedGidenPersonelEmails;
            let SELECTED_PERSONEL;
            let CREATED_ISLETME;
            let SEARCH;
            let PERSONEL_CONTAINER;

            // Gidilen Kurum
            let selectedGidilecekPersonelEmails;
            let OTHER_SEARCH;
            let ISLETME;
            let ARAMA_CONTAINER;
            let SELECTED_GIDILECEK_PERSONEL;

            let submit;

            getDataTableDatas('#toplantilar', `yonetim/toplantilar/${isletmeler_select.value}`);

            isletmeler_select.addEventListener('change', async () => {
                $('#toplantilar').DataTable().destroy();
                getDataTableDatas('#toplantilar', `yonetim/toplantilar/${isletmeler_select.value}`);
            });

            document.body.addEventListener('click', async (event) => {
                if (event.target.matches('.open-modal')) {
                    if (event.target.dataset.eventType === "duzenle") {
                        await getModal(event.target.dataset.id);
                    } else {
                        await getModal();
                        await createPersonelCard('{{ encrypt(Auth::user()->kullanicilar_id) }}',
                            selectedGidenPersonelEmails, SELECTED_PERSONEL);
                    }
                }
                if (event.target.matches('.removeSelectedGidenPersonelEmail')) {
                    event.target.closest('.flex').remove();
                    selectedGidenPersonelEmails = selectedGidenPersonelEmails.filter(
                        email => email !== event.target.dataset.email
                    );
                    if (selectedGidenPersonelEmails.length == 0) {
                        CREATED_ISLETME.disabled = false;
                    } else {
                        CREATED_ISLETME.disabled = true;
                    }
                }
                if (event.target.matches('.removeSelectedDavetPersonelEmail')) {
                    event.target.closest('.flex').remove();
                    selectedGidilecekPersonelEmails = selectedGidilecekPersonelEmails.filter(
                        email => email !== event.target.dataset.email
                    );
                    if (selectedGidenPersonelEmails.length == 0) {
                        ISLETME.disabled = false;
                    } else {
                        ISLETME.disabled = true;
                    }
                }
                if (!ARAMA_CONTAINER.contains(event.target)) {
                    ARAMA_CONTAINER.innerHTML = "";
                }
                if (!PERSONEL_CONTAINER.contains(event.target)) {
                    PERSONEL_CONTAINER.innerHTML = "";
                }
            });

            async function getModal($etkinlikler_id = null) {
                let URL = 'yonetim/toplantilar/ziyaret/talep/ziyaretTalepModalGetir';

                if ($etkinlikler_id) {
                    URL += `/${$etkinlikler_id}`;
                }

                const RESPONSE_DATA = await fetchData(URL);

                if (RESPONSE_DATA.success) {
                    modal_content.innerHTML = RESPONSE_DATA.html;
                    //
                    tanimlamalariYap(RESPONSE_DATA.gidenKullanicilarEmails, RESPONSE_DATA
                        .gidilecekKullanicilarEmails);
                } else {
                    errorAlert(RESPONSE_DATA.message);
                }
            }
            await getModal();

            async function createPersonelCard(id, list, container, isDavetci = false) {
                const formData = new FormData();
                // Sol taraf kullanıcılar id gönderilir
                // Sağ taraf için kullanici_birim_unvan_iliskileri_id gönderilir
                formData.append('kullanicilar_id', id);

                let URL = 'yonetim/toplantilar/ziyaret/talep/personel-card';

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
                    await fetchData('yonetim/toplantilar/ziyaret/talep/personeller', formData, true);

                if (RESPONSE_DATA.success) {
                    PERSONEL_CONTAINER.innerHTML = RESPONSE_DATA.html;

                    const checkboxes = PERSONEL_CONTAINER.querySelectorAll('input[type="checkbox"]');
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
                selectedGidilecekPersonelEmails.forEach(item => formData.append('searchNot[]', item));

                const RESPONSE_DATA =
                    await fetchData('yonetim/toplantilar/ziyaret/talep/personeller/yonetici', formData,
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

            function tanimlamalariYap(gidenKullanicilarEmails, gidilecekKullanicilarEmails) {
                // Ziyaret Ekibi
                selectedGidenPersonelEmails = gidenKullanicilarEmails;
                SELECTED_PERSONEL = document.querySelector('#selectedPersonel');
                CREATED_ISLETME = document.querySelector('#olusturan_isletmeler_id');
                SEARCH = document.querySelector('#search');
                PERSONEL_CONTAINER = document.querySelector('#gidecekPersoneller');

                // Gidilen Kurum
                selectedGidilecekPersonelEmails = gidilecekKullanicilarEmails;
                OTHER_SEARCH = document.querySelector('#otherSearch');
                ISLETME = document.querySelector('#gidilen_isletmeler_id');
                ARAMA_CONTAINER = document.querySelector('#gidilecekPersoneller');
                SELECTED_GIDILECEK_PERSONEL = document.querySelector('#selectedGidilecekPersonel');

                if (selectedGidilecekPersonelEmails.length == 0) {
                    ISLETME.disabled = false;
                } else {
                    ISLETME.disabled = true;
                }

                if (selectedGidenPersonelEmails.length == 0) {
                    CREATED_ISLETME.disabled = false;
                } else {
                    CREATED_ISLETME.disabled = true;
                }

                submit = document.querySelector('button[type="submit"]')

                submit.addEventListener('click', async (e) => {
                    e.preventDefault();
                    submit.disabled = true;
                    submit.textContent = 'Gönderiliyor...';
                    ISLETME.disabled = false;
                    CREATED_ISLETME.disabled = false;
                    try {
                        const formData = new FormData(submit.closest('form'));
                        console.log(Object.fromEntries(formData));

                        let URL = 'yonetim/toplantilar/ziyaret/talep/';

                        if (e.target.dataset.eventType == 'duzenle')
                            URL += 'duzenle';
                        else
                            URL += 'olustur';

                        const RESPONSE_DATA = await fetchData(URL, formData, true);

                        if (RESPONSE_DATA.success) {
                            successAlert(RESPONSE_DATA.message);
                            modal.classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                            $('#toplantilar').DataTable().ajax.reload(null, false);
                        } else {
                            if (RESPONSE_DATA.errors) {
                                for (const [key, value] of Object.entries(RESPONSE_DATA.errors))
                                    errorAlert(value);
                            } else
                                errorAlert(RESPONSE_DATA.message);
                        }
                    } catch (error) {
                        errorAlert(error);
                    } finally {
                        e.target.textContent = e.target.dataset.eventType == 'duzenle' ?
                            'Ziyaret Düzenle' : 'Ziyaret Oluştur';
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

                async function handleSearch() {
                    if (SEARCH.value.length < 3) {
                        PERSONEL_CONTAINER.innerHTML = '';
                        return;
                    }
                    await getPersonel();
                }

                async function handleOtherSearch() {
                    if (OTHER_SEARCH.value.length < 3) {
                        ARAMA_CONTAINER.innerHTML = '';
                        return;
                    }
                    await getYonetici();
                }

                SEARCH.addEventListener('input', handleSearch);
                SEARCH.addEventListener('focus', handleSearch);
                OTHER_SEARCH.addEventListener('input', handleOtherSearch)
                OTHER_SEARCH.addEventListener('focus', handleOtherSearch)
            }
        });
    </script>
@endsection
