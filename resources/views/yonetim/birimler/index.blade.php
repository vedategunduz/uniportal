@extends('layouts.auth')

@section('title', 'User dashboard')

@section('links')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.0/css/dataTables.dataTables.css" />
    <style>
        select.dt-input {
            width: 60px;
        }

        .datatable-search {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
@endsection

@section('content')
    <div class="p-2 bg-blue-700 text-white mb-8 flex space-x-2 items-center justify-between">
        <h4>Birim işlemleri</h4>
        <div class="flex item-center">
            <button type="button" data-modal="personellerModal"
                class="open-modal personelListesi bg-red-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white">
                Birime yerleşmemiş kullanıcılar({{ $birimYerlesmemisKullanicilarSayisi }})
            </button>
            <button type="button"
                class="bg-emerald-500 text-sm pl-2 py-1.5 pr-4 rounded flex items-center text-white ms-2 open-modal birimDuzenle"
                data-modal="birimDetay" data-id="{{ encrypt(0) }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-5 pointer-events-none">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span class="pointer-events-none">
                    Ekle
                </span>
            </button>
        </div>
    </div>

    <table id="birimler" class="display nowrap stripe" style="width:100%">
        <thead>
            <tr>
                <th class="w-96">Birim adı</th>
                <th data-dt-order="disable">Personel listesi</th>
                <th class="w-4" data-dt-order="disable"></th>
                <th class="w-4" data-dt-order="disable"></th>
            </tr>
        </thead>
        <tbody id="tableBody">

        </tbody>
    </table>

    <section class="modal hidden" id="birimDetay">
        <div class="modal-outside close-modal" data-modal="birimDetay"></div>

        <div class="modal-content max-w-screen-sm min-h-24 rounded-lg">
            <header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t-lg">
                <div>
                    <h2 class="font-medium text-lg text-white">Birim detayları</h2>
                </div>
                <button class="close-modal" data-modal="birimDetay">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </header>

            <section id="modalContent" class="p-6"></section>
        </div>
    </section>

    <section class="modal hidden" id="birimDegistir">
        <div class="modal-outside close-modal" data-modal="birimDegistir"></div>

        <div class="modal-content max-w-sm min-h-24 rounded-lg">
            <header class="flex items-center justify-between bg-yellow-400 text-white px-6 py-3 rounded-t-lg">
                <div>
                    <h2 class="font-medium text-lg text-white">Birimi Değiştir</h2>
                </div>
                <button class="close-modal" data-modal="birimDegistir">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </header>

            <form action="" method="POST" id="birimDegistirForm" class="p-6">
                <section>
                    <input type="hidden" name="hidden_isletme_birimleri_id" value="" hidden
                        placeholder="isletme birimi">
                    <input type="hidden" name="kullanici_birim_unvan_iliskileri_id" value=""
                        placeholder="kullanici unvan iliskisi" hidden>

                    <label for="isletme_birimleri_id">Birimler</label>
                    <select name="isletme_birimleri_id" id="isletme_birimleri_id"
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                        @foreach ($isletmeBirimleri as $rowBirim)
                            <option value="{{ encrypt($rowBirim->isletme_birimleri_id) }}">{{ $rowBirim->baslik }}
                            </option>
                        @endforeach
                    </select>
                </section>

                <footer class="mt-6 text-right">
                    <button type="submit"
                        class="bg-amber-500 text-white px-3 py-2 rounded hover:bg-amber-700 transition">Birimi
                        değiştir</button>
                </footer>
            </form>
        </div>
    </section>

    <section class="modal hidden" id="confirmModal">
        <div class="modal-outside close-modal" data-modal="confirmModal"></div>

        <div class="modal-content max-w-sm rounded-lg">
            <header class="flex items-center justify-between bg-red-700 text-white px-6 py-3 rounded-t-lg">
                <div>
                    <h2 class="font-medium text-lg text-white">Birimi kaldır</h2>
                </div>
                <button class="close-modal" data-modal="confirmModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </header>

            <form action="" method="POST" id="confirmForm" class="p-6">
                <section>
                    <input type="hidden" name="silme_hidden_isletme_birimleri_id" value="" hidden
                        placeholder="isletme birimi">
                </section>

                <p class="mb-4">Birimi kaldırmak istediğinizden emin misiniz?</p>

                <footer class="grid grid-cols-2 gap-2">
                    <button data-modal="confirmModal" type="button"
                        class="close-modal bg-gray-50 text-gray-900 px-3 py-2 rounded hover:bg-gray-100 transition">Hayır</button>

                    <button type="submit"
                        class="bg-red-700 text-white px-3 py-2 rounded hover:bg-red-800 transition">Evet</button>
                </footer>
            </form>
        </div>
    </section>

    <section class="modal hidden" id="personellerModal">
        <div class="modal-outside close-modal" data-modal="personellerModal"></div>

        <div class="modal-content max-w-5xl min-h-24 rounded-lg">
            <header class="flex items-center justify-between bg-blue-700 text-white px-6 py-3 rounded-t-lg">
                <div>
                    <h2 class="font-medium text-lg text-white">Personeller</h2>
                </div>
                <button class="close-modal" data-modal="personellerModal">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5 pointer-events-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </header>

            <section id="personellerModalContent" class="p-6">

            </section>
        </div>
    </section>
@endsection


@section('scripts')
    <script>
        $('#birimler').DataTable({
            lengthMenu: [20, 40, 100, {
                'label': 'Hepsi',
                'value': -1
            }],
            ajax: {
                url: '/birimler/getir',
                type: 'POST',
                body: {
                    _token: CSRF_TOKEN
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                dataSrc: 'data',
            },
        });
        $('#birimler').on('draw.dt', function() {
            document.querySelectorAll('[data-popover-target]').forEach(triggerEl => {
                const targetEl = document.getElementById(triggerEl.getAttribute(
                    'data-popover-target'));
                new Popover(targetEl, triggerEl);
            });
        });

        window.addEventListener('click', function(event) {
            // if (event.target.matches('.birimdenCikart')) {
            //     fetchData(`${BASE_URL}/yonetim/birimler/kullanici/${event.target.dataset.id}`);

            //     if (event.target.dataset.birimid != 0) {
            //         modalPersonelListesiGuncelle(event.target.dataset.birimid);
            //     }
            // }

            if (event.target.matches('.birimDegistir')) {
                document.querySelector('[name=kullanici_birim_unvan_iliskileri_id]').value = event.target.dataset
                    .id;
                document.querySelector('[name=hidden_isletme_birimleri_id]').value = event.target.dataset.birimid;
            }

            if (event.target.matches('.birimSil')) {
                document.querySelector('input[type=hidden][name="silme_hidden_isletme_birimleri_id"]').value = event
                    .target.dataset.id;
            }

            if (event.target.matches('.birimDuzenle')) {
                (async function() {
                    const RESPONSE_DATA = await fetchData(
                        `yonetim/birimler/modal/${event.target.dataset.id}`);

                    if (RESPONSE_DATA.success) {
                        document.getElementById('modalContent').innerHTML = RESPONSE_DATA.html;
                        modalPersonelListesiGuncelle(event.target.dataset.id);
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
                        document.getElementById('personellerModal').classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
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
                const formData = new FormData(document.getElementById('birimDetayForm'));

                if (event.target.dataset.buttonType === 'duzenle') {
                    (async () => {
                        const RESPONSE_DATA = await fetchData('yonetim/birimler/guncelle', formData, true);

                        if (RESPONSE_DATA.success) {
                            $('#birimler').DataTable().ajax.reload(null, false);
                            console.log(RESPONSE_DATA);
                            successAlert(RESPONSE_DATA.message);
                            document.getElementById('birimDetay').classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        } else {
                            errorAlert(RESPONSE_DATA.message);
                        }
                    })();
                } else {
                    (async () => {
                        const RESPONSE_DATA = await fetchData('yonetim/birimler/ekle', formData, true);

                        if (RESPONSE_DATA.success) {
                            $('#birimler').DataTable().ajax.reload(null, false);
                            successAlert(RESPONSE_DATA.message);
                            document.getElementById('birimDetay').classList.add('hidden');
                            document.body.classList.remove('overflow-hidden');
                        } else {
                            errorAlert(RESPONSE_DATA.message);
                        }
                    })();
                }
            }
        });

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
            const RESPONSE_DATA = await fetchData('yonetim/birimler/birimeYerlesmemisPersonelSayisi');

            if (RESPONSE_DATA.success) {
                const button = document.querySelector('button[data-modal=personellerModal]');
                if (button) {
                    button.textContent = `Birime yerleşmemiş personeller(${RESPONSE_DATA.message})`;
                }
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        }
        birimeYerlesmemisPersonelSayisiGetir();

        document.querySelector('.personelListesi')?.addEventListener('click', async function() {
            (async function() {
                const RESPONSE_DATA = await fetchData('yonetim/birimler/personeller');

                if (RESPONSE_DATA.success) {
                    document.getElementById('personellerModalContent').innerHTML = RESPONSE_DATA.html;
                } else {
                    errorAlert('Personel listesi gösterilemedi.');
                }
            })();
        });

        document.getElementById('birimDegistirForm')?.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            const RESPONSE_DATA = await fetchData('yonetim/birimler/personelBirimDegistir', formData,
                true)

            if (RESPONSE_DATA.success) {
                $('#birimler').DataTable().ajax.reload(null, false);
                successAlert(RESPONSE_DATA.message);
                document.getElementById('birimDegistir').classList.add('hidden');

                if (Object.fromEntries(formData)['hidden_isletme_birimleri_id'] != 0) {
                    modalPersonelListesiGuncelle(Object.fromEntries(formData)[
                        'hidden_isletme_birimleri_id']);
                }
                document.body.classList.remove('overflow-hidden');
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        });

        document.getElementById('confirmForm')?.addEventListener('submit', async function(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const RESPONSE_DATA = await fetchData('birimler/sil', formData, true)

            if (RESPONSE_DATA.success) {
                $('#birimler').DataTable().ajax.reload(null, false);
                successAlert(RESPONSE_DATA.message);
                birimeYerlesmemisPersonelSayisiGetir();
                document.getElementById('confirmModal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                errorAlert(RESPONSE_DATA.message);
            }
        });

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
            const RESPONSE_DATA = await fetchData(`yonetim/birimler/kullanici/${id}`);
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
