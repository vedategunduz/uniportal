@extends('layouts.auth')

@section('title', 'User dashboard')

@section('content')
    {{-- 13 --}}
    <div class="flex justify-between items-center bg-blue-700 text-white mb-8 p-2 rounded">
        <h4>Ziyaret Yönetimi</h4>
        <div class="flex items-center gap-4">
            <select name="isletmeler_id" id="isletmeChange" @class([
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
                    <th class="">Ad</th>
                    <th class="">Konu</th>
                    <th class="">Tarih</th>
                    <th>Durum</th>
                    <th class="w-4"></th>
                </tr>
            </thead>
            <tbody id="table-body"></tbody>
        </table>
    </div>

    <div class="space-y-2">
        <div class="h-4 bg-gray-500 w-96"></div>
        <div class="h-4 bg-gray-500 max-w-screen-lg"></div>
        <div class="h-4 bg-gray-500 max-w-screen-xl"></div>
        <div class="h-4 bg-gray-500 max-w-screen-2xl"></div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const modal_content = document.querySelector('#modal-content');

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

            const SELECTED_PERSONEL = document.querySelector('#selectedPersonel');
            const CREATED_ISLETME   = document.querySelector('#olusturan_isletmeler_id');
            const SEARCH            = document.querySelector('#search');
            const PERSONEL_COTAINER = document.querySelector('#gidecekPersoneller');
            let selectedPersonelEmails = [];

            async function createPersonelCard(id) {
                const formData = new FormData();
                formData.append('kullanicilar_id', id);

                const RESPONSE_DATA =
                    await fetchData('api/modal/toplantilar/ziyaret/talep/personel-card', formData, true);

                if (RESPONSE_DATA.success) {
                    SELECTED_PERSONEL.innerHTML += RESPONSE_DATA.html;
                    selectedPersonelEmails.push(RESPONSE_DATA.email);
                } else {
                    errorAlert(RESPONSE_DATA.message);
                }
            }
            await createPersonelCard('{{ encrypt(Auth::user()->kullanicilar_id) }}');

            async function getPersonel() {
                const formData = new FormData();

                formData.append('isletmeler_id', CREATED_ISLETME.value);
                formData.append('search', SEARCH.value);

                const RESPONSE_DATA =
                    await fetchData('api/modal/toplantilar/ziyaret/talep/personeller', formData, true);

                if (RESPONSE_DATA.success) {
                    PERSONEL_COTAINER.innerHTML = RESPONSE_DATA.html;

                    const checkboxes = PERSONEL_COTAINER.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', () => {
                            createPersonelCard(checkbox.value);
                        });

                        if (selectedPersonelEmails.includes(checkbox.dataset.email)) {
                            checkbox.checked = true;
                        }
                    });
                } else
                    errorAlert(RESPONSE_DATA.message);
            }

            CREATED_ISLETME.addEventListener('change', async () => {
                await getPersonel();
            });

            SEARCH.addEventListener('input', async () => {
                if (SEARCH.value.length < 3) {
                    PERSONEL_COTAINER.innerHTML = '';
                    return;
                }
                await getPersonel();
            });
        });
    </script>
@endsection
