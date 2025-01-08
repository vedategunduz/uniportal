document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('etkinlikForm');

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const formData = new FormData(form);

        try {
            const response = await fetch('http://127.0.0.1:8000/yonetim/etkinlikler/ekle', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error('Ağ yanıtı uygun değil: ' + response.statusText);
            }

            const responseData = await response.json();
            console.log('Başarılı:', responseData);
            if(responseData.success) {
                document.getElementById('etkinlikModal').classList.add('hidden');
            }
        } catch (error) {
            console.error('Hata:', error);
        }
    });
});
