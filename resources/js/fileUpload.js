export default class FileUpload {
    constructor(container) {
        this.container = container;
        this.fileInput = container.querySelector('input[type="file"]');
        this.fileUploadUrl = this.fileInput.dataset.url;
        this.dropArea = container.querySelector('[data-drop-area]');
        this.fileListContainer = container.querySelector('[data-file-list-container]');
        // Seçilen dosyaları { file, link } nesnesi şeklinde saklıyoruz.
        this.selectedFiles = [];
        this.init();
    }

    // File input'un değerini güncellemek için DataTransfer kullanıyoruz
    updateFileInput() {
        const dataTransfer = new DataTransfer();
        this.selectedFiles.forEach(entry => {
            dataTransfer.items.add(entry.file);
        });
        this.fileInput.files = dataTransfer.files;
    }

    // Dosya listesini günceller
    updateFileList() {
        this.fileListContainer.innerHTML = ''; // Önceki listeyi temizle

        this.selectedFiles.forEach((entry, index) => {
            const file = entry.file;

            // Ana kapsayıcı div
            const fileDiv = document.createElement('div');
            fileDiv.className = 'flex items-center gap-2 text-gray-500 mb-2';

            let previewElement;
            if (file.type.startsWith('image/')) {
                // Resim önizlemesi için kapsayıcı oluşturuyoruz
                const containerDiv = document.createElement('div');
                containerDiv.className = 'w-16 h-16 rounded object-cover skeleton shrink-0';

                previewElement = document.createElement('img');
                previewElement.className = 'w-full h-full object-cover rounded';
                containerDiv.appendChild(previewElement);

                // FileReader ile resmi oku
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewElement.src = e.target.result;
                };
                // Resim yüklendiğinde skeleton efektini kaldır
                previewElement.addEventListener('load', () => {
                    containerDiv.classList.remove('skeleton');
                });
                reader.readAsDataURL(file);

                fileDiv.appendChild(containerDiv);
            } else {
                // Resim değilse simge kullan
                previewElement = document.createElement('i');
                previewElement.className = 'bi bi-file-earmark text-3xl';
                fileDiv.appendChild(previewElement);
            }

            // Dosya bilgilerini gösteren alan
            const infoDiv = document.createElement('div');
            infoDiv.className = 'flex flex-col';
            const nameSpan = document.createElement('span');
            nameSpan.textContent = file.name;
            const sizeSpan = document.createElement('span');
            sizeSpan.textContent = this.formatBytes(file.size);
            infoDiv.appendChild(nameSpan);
            infoDiv.appendChild(sizeSpan);

            // Eğer dosya yüklenmişse, linki göster; henüz yüklenmediyse upload işlemini başlatıyoruz.
            if (entry.link) {
                const linkEl = document.createElement('a');
                linkEl.href = entry.link;
                linkEl.textContent = entry.link;
                linkEl.className = 'text-xs text-blue-500 cursor-pointer mt-1 text-wrap';
                linkEl.addEventListener('click', (e) => {
                    e.preventDefault();
                    navigator.clipboard.writeText(entry.link);
                    ApiService.alert.success('Dosya linki kopyalandı.');
                });
                infoDiv.appendChild(linkEl);
            } else {
                // Henüz yüklenmemişse yükleme işlemini başlat
                this.uploadFile(entry);
            }
            fileDiv.appendChild(infoDiv);

            // Kaldırma butonu (x)
            const removeButton = document.createElement('x-button');
            removeButton.className = 'ml-auto !shadow-none !bg-transparent !border-none !p-1';
            removeButton.innerHTML = '<i class="bi bi-x text-lg cursor-pointer"></i>';
            removeButton.addEventListener('click', () => {
                this.selectedFiles.splice(index, 1);
                this.updateFileList();
                this.updateFileInput();
            });
            fileDiv.appendChild(removeButton);

            this.fileListContainer.appendChild(fileDiv);
        });
    }

    // Dosya yükleme işlemi: Her dosya için formData oluşturulur ve sunucuya fetch ile gönderilir.
    // Yükleme başarılı olursa, dönen link entry.link olarak kaydedilir ve updateFileList() çağrılarak UI güncellenir.
    uploadFile(entry) {
        let formData = new FormData();
        formData.append('dosya', entry.file);

        (async () => {
            try {
                const response = await ApiService.fetchData(this.fileUploadUrl, formData, 'POST');

                if (response.status !== 201) {
                    return ApiService.alert.error(`Dosya yükleme hatası: ${response.message}`);
                }

                if (response.data.success) {
                    entry.link = response.data.url; // Sunucudan dönen linki kaydediyoruz
                    // Dosya yüklendikten sonra listeyi yeniden render ediyoruz ki link görünsün.
                    this.updateFileList();
                }
            } catch (err) {
                console.log(err, 123);
                // ApiService.alert.error('Dosya yükleme hatası.', err.message);
            }
        })();
    }

    // Dosya boyutunu okunabilir formata çevirir
    formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    init() {
        // Dosya input değişiminde; seçilen her dosyayı { file, link } nesnesi olarak saklıyoruz.
        this.fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files).map(file => ({ file, link: null }));
            this.selectedFiles = this.selectedFiles.concat(files);
            this.updateFileList();
            this.updateFileInput();
        });

        // Drag & Drop için varsayılan davranışı engelle
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            this.dropArea.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        // Dosya bırakma işlemi gerçekleştiğinde
        this.dropArea.addEventListener('drop', (e) => {
            const files = Array.from(e.dataTransfer.files).map(file => ({ file, link: null }));
            this.selectedFiles = this.selectedFiles.concat(files);
            this.updateFileList();
            this.updateFileInput();
        });
    }
}
