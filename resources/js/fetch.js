import { errorAlert, successAlert } from './alert';

const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export async function fetchData(url, data) {
    const RESPONSE = await fetch(url, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        body: JSON.stringify(data)
    });

    if (!RESPONSE.ok) {
        // 422 ise validation hataları dönmüş demektir
        if (RESPONSE.status === 422) {
            // Gelen JSON verisini parse et
            const errorData = await RESPONSE.json();

            // İsterseniz her bir field ve mesajını DOM'a yazdırabilirsiniz
            for (const [field, messages] of Object.entries(errorData.errors)) {
                messages.forEach(msg => {
                    errorAlert(`${msg}`);
                });
            }

            return; // Burada return diyerek sonraki kodlara geçmiyoruz.
        } else {
            // 422 dışındaki hatalar için (örnek: 500 vs.)
            throw new Error('Ağ yanıtı uygun değil: ' + RESPONSE.statusText);
        }
    }

    const RESPONSE_DATA = await RESPONSE.json();

    if (RESPONSE_DATA.success) {
        successAlert(RESPONSE_DATA.message);
    } else if (RESPONSE_DATA.error) {
        errorAlert('Oopss! Bir hata oluştu. Lütfen bildirin.');
    }
}
