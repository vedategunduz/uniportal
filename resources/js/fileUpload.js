export default class FileUpload {
    constructor() {
        this.init();
    }

    init() {
        // Container'ı seçiyoruz; sayfada yoksa çıkıyoruz.
        this.container = document.querySelector('[data-file-upload]');
        if (!this.container) {
            console.warn('FileUpload: Container bulunamadı.');
            return;
        }

        // Alt öğeleri seçiyoruz
        this.fileInput = this.container.querySelector('input[type="file"]');
        if (!this.fileInput) {
            console.warn('FileUpload: File input bulunamadı.');
            return;
        }
        this.fileUploadUrl = this.fileInput.dataset.url || '';

        // Birden fazla data-drop-area olsa da, <div> olanı tercih ediyoruz.
        this.dropArea = this.container.querySelector('div[data-file-drop-area]');
        if (!this.dropArea) {
            // Eğer <div> yoksa herhangi bir öğe seçiliyor.
            this.dropArea = this.container.querySelector('[data-file-drop-area]');
        }

        this.fileListContainer = this.container.querySelector('[data-file-list-container]');
        if (!this.fileListContainer) {
            console.warn('FileUpload: File list container bulunamadı.');
            return;
        }

        // Eğer daha önce dosya seçimi yapılmadıysa dizi oluşturuyoruz.
        if (!this.selectedFiles) {
            this.selectedFiles = [];
        }

        // File input'a listener ekliyoruz, eklenmişse tekrar eklemiyoruz.
        if (!this.fileInput.__fileUploadInitialized) {
            this.fileInput.addEventListener('change', this.handleFileInputChange.bind(this));
            this.fileInput.__fileUploadInitialized = true;
        }

        // Eğer dropArea mevcutsa, onun için de event listener ekliyoruz.
        if (this.dropArea && !this.dropArea.__fileUploadInitialized) {
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                this.dropArea.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });
            this.dropArea.addEventListener('drop', this.handleDrop.bind(this));
            this.dropArea.__fileUploadInitialized = true;
        }

        console.log('FileUpload initialized');
        // Mevcut dosyalar varsa güncel listeyi çiziyoruz.
        this.updateFileList();
    }

    handleFileInputChange(e) {
        const files = Array.from(e.target.files).map(file => ({
            file,
            link: null,
            isUploading: false
        }));
        this.selectedFiles = this.selectedFiles.concat(files);
        this.updateFileList();
        this.updateFileInput();
    }

    handleDrop(e) {
        const files = Array.from(e.dataTransfer.files).map(file => ({
            file,
            link: null,
            isUploading: false
        }));
        this.selectedFiles = this.selectedFiles.concat(files);
        this.updateFileList();
        this.updateFileInput();
    }

    updateFileInput() {
        if (!this.fileInput) return;
        const dataTransfer = new DataTransfer();
        this.selectedFiles.forEach(entry => {
            dataTransfer.items.add(entry.file);
        });
        this.fileInput.files = dataTransfer.files;
    }

    updateFileList() {
        if (!this.fileListContainer) return;
        this.fileListContainer.innerHTML = ''; // Önceki listeyi temizle

        this.selectedFiles.forEach((entry, index) => {
            const file = entry.file;
            const fileDiv = document.createElement('div');
            fileDiv.className = 'flex items-center gap-2 text-gray-500 mb-2';
            let previewElement;

            if (file.type.startsWith('image/')) {
                // Resim için önizleme alanı oluşturuyoruz
                const containerDiv = document.createElement('div');
                containerDiv.className = 'w-16 h-16 rounded object-cover skeleton shrink-0';

                previewElement = document.createElement('img');
                previewElement.className = 'w-full h-full object-cover rounded';
                containerDiv.appendChild(previewElement);

                // Önce load event listener'ı ekliyoruz, sonra src'yi atıyoruz
                previewElement.addEventListener('load', () => {
                    containerDiv.classList.remove('skeleton');
                });

                const reader = new FileReader();
                reader.onload = (e) => {
                    previewElement.src = e.target.result;
                };
                reader.readAsDataURL(file);

                fileDiv.appendChild(containerDiv);
            } else {
                // Resim değilse simge gösteriyoruz
                previewElement = document.createElement('i');
                previewElement.className = 'bi bi-file-earmark text-3xl';
                fileDiv.appendChild(previewElement);
            }

            // Dosya bilgilerini içeren alan
            const infoDiv = document.createElement('div');
            infoDiv.className = 'flex flex-col';
            const nameSpan = document.createElement('span');
            nameSpan.textContent = file.name;
            const sizeSpan = document.createElement('span');
            sizeSpan.textContent = this.formatBytes(file.size);
            infoDiv.appendChild(nameSpan);
            infoDiv.appendChild(sizeSpan);

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

    formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    // Refresh, eğer container/alt öğeler sonradan eklendiyse init()'i yeniden çağırır.
    refresh() {
        this.init();
    }
}
