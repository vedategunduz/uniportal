// import { initDataTable } from './data-table';
import { changeModal } from './modal';
import { fetchData } from './fetch';

const BASE_URL = window.App.baseUrl;

document.addEventListener('DOMContentLoaded', function () {
    // DataTable'i başlat
    // initDataTable();

    // Modal açma butonları
    document.querySelectorAll('.etkinlik-open-modal').forEach(function (button) {
        button.addEventListener('click', function () {
            changeModal(`${BASE_URL}/kullanici/etkinlikler/modal/ekle`);
            const modal = document.getElementById(button.dataset.modalTarget);
            document.body.classList.add('overflow-hidden');
            modal.classList.remove('hidden');
        });
    });

    // Modal kapama
    document.getElementById('etkinlikModal')?.addEventListener('click', function (event) {
        if (event.target.matches('.close-modal')) {
            const modalId = event.target.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            document.body.classList.remove('overflow-hidden');
            modal.classList.add('hidden');
        }
    });

    // Etkinlik düzenleme
    document.querySelectorAll('.etkinlikDuzenleButton').forEach(function (button) {
        button.addEventListener('click', function (event) {
            changeModal(`${BASE_URL}/yonetim/etkinlikler/modal/duzenle/${button.dataset.target}`);

            const modalId = event.target.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            document.body.classList.add('overflow-hidden');
            modal.classList.remove('hidden');
        });
    });

    window.onclick = function (event) {
        if (event.target.matches('.birimdenCikart')) {
            fetchData(`${BASE_URL}/yonetim/birimler/kullanici/${event.target.dataset.id}`);
        }

        if (event.target.matches('.birimDegistir')) {
            document.querySelector('[name=kullanici_birim_unvan_iliskileri_id]').value = event.target.dataset.id;
        }

        if (event.target.matches('.open-modal')) {
            const MODAL = document.getElementById(event.target.dataset.modal);

            MODAL.classList.remove('hidden');
            MODAL.classList.add('flex');

            document.body.classList.add('overflow-hidden');
        }

        if (event.target.matches('.close-modal')) {
            const MODAL = document.getElementById(event.target.dataset.modal);

            MODAL.classList.remove('flex');
            MODAL.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');
        }
    };
});
