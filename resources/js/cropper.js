import * as modal from './modal';
import * as alert from './alert';
import Cropper from 'cropperjs';

class ImageCropper {
    constructor({
        inputSelector,
        imageSelector,
        cropButtonSelector,
        modalSelector,
        previewImageSelector,
        aspectRatio = 4 / 3,
        viewMode = 1,
    }) {
        this.inputElement = document.querySelector(inputSelector);
        this.imageElement = document.querySelector(imageSelector);
        this.cropButtonElement = document.querySelector(cropButtonSelector);
        this.modalElement = document.querySelector(modalSelector);
        this.previewImageElement = document.querySelector(previewImageSelector);

        this.aspectRatio = aspectRatio;
        this.viewMode = viewMode;
        this.cropper = null;
        this.originalName = null;

        // Eventleri başlatalım
        this.init();
    }

    init() {
        console.log('ImageCropper initialized');
        this.inputElement.addEventListener('change', (e) => this.handleFileChange(e));
        this.cropButtonElement.addEventListener('click', () => this.handleCrop());
    }

    handleFileChange(event) {
        const files = event.target.files;
        if (!files || files.length === 0) return;

        const file = files[0];
        this.originalName = file.name;

        // Görsel format kontrolü
        if (!/^image\/\w+/.test(file.type)) {
            alert.error('Lütfen bir resim dosyası seçin.');
            return;
        }

        // Daha önce bir cropper tanımlıysa yok et
        if (this.cropper) {
            this.cropper.destroy();
        }

        // Resmi yükleyip Cropper'ı başlat
        const imageURL = URL.createObjectURL(file);
        this.imageElement.src = imageURL;

        this.cropper = new Cropper(this.imageElement, {
            aspectRatio: this.aspectRatio,
            viewMode: this.viewMode,
        });

        // Modal göster
        modal.show(this.modalElement);
    }

    handleCrop() {
        if (!this.cropper) return;

        // Kırpılmış canvas'i al
        const canvas = this.cropper.getCroppedCanvas({
            fillColor: '#fff', // Transparan bölgeler beyaz olsun
        });

        // Canvas'i blob'a dönüştür
        canvas.toBlob(
            (blob) => {
                if (!blob) return;

                // Blob -> File
                const fileOptions = { type: 'image/jpeg' };
                const croppedFile = new File([blob], this.originalName, fileOptions);

                // Önizleme
                if (this.previewImageElement) {
                    const croppedImageURL = URL.createObjectURL(croppedFile);
                    this.previewImageElement.src = croppedImageURL;
                }

                // Input'a yeni dosyayı koyalım
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                this.inputElement.files = dataTransfer.files;

                // Modal kapat
                modal.hide(this.modalElement);
            },
            'image/jpeg',
            0.8
        );
    }

    destroy() {
        if (this.cropper) {
            this.cropper.destroy();
            this.cropper = null;
        }
    }
}

export default ImageCropper;
