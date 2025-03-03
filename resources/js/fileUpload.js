export default class FileUpload {
    constructor(container) {
        this.container = container;
        this.fileInput = container.querySelector('input[type="file"]');
        this.dropArea = container.querySelector('[data-drop-area]');
        this.fileListContainer = container.querySelector('[data-file-list-container]');
        this.selectedFiles = [];
        this.init();
    }

    // File input'un değerini güncellemek için DataTransfer kullanıyoruz
    updateFileInput() {
        const dataTransfer = new DataTransfer();
        this.selectedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });
        this.fileInput.files = dataTransfer.files;
    }

    // Dosya listesini günceller
    updateFileList() {
        this.fileListContainer.innerHTML = ''; // Önceki listeyi temizle

        this.selectedFiles.forEach((file, index) => {
            // Ana kapsayıcı div
            const fileDiv = document.createElement('div');
            fileDiv.className = 'flex items-center gap-2 text-gray-500 mb-2';

            let previewElement;
            if (file.type.startsWith('image/')) {
                // Resim önizlemesi için kapsayıcı oluşturuyoruz
                const containerDiv = document.createElement('div');
                // Resim yüklenene kadar skeleton efektini container üzerinde gösteriyoruz
                containerDiv.className = 'w-16 h-16 rounded object-cover skeleton';

                previewElement = document.createElement('img');
                previewElement.className = 'w-full h-full object-cover rounded hidden';
                containerDiv.appendChild(previewElement);

                const reader = new FileReader();
                reader.onload = (e) => {
                    previewElement.src = e.target.result;
                    previewElement.classList.remove('hidden');
                };
                // Resim tamamen yüklendiğinde, containerDiv'den skeleton sınıfını kaldırıyoruz
                previewElement.addEventListener('load', () => {
                    containerDiv.classList.remove('skeleton');
                });
                reader.readAsDataURL(file);

                fileDiv.appendChild(containerDiv);
            } else {
                // Resim değilse simge veya placeholder kullan
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

    // Dosya boyutunu okunabilir formata çevirir
    formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }

    // Event listener'ları kurar
    init() {
        // Dosya input değişiminde
        this.fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
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
            const files = Array.from(e.dataTransfer.files);
            this.selectedFiles = this.selectedFiles.concat(files);
            this.updateFileList();
            this.updateFileInput();
        });
    }
}
