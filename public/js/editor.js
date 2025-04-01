class ImageEditor {
    constructor() {
        this.canvas = document.createElement('canvas');
        this.ctx = this.canvas.getContext('2d');
        this.image = new Image();
        this.setupEventListeners();
        this.originalSettings = {
            brightness: 100,
            contrast: 100
        };
    }

    setupEventListeners() {
        // File input handler
        const fileInput = document.querySelector('#file-input');
        if (fileInput) {
            fileInput.addEventListener('change', (e) => this.handleFileUpload(e.target.files[0]));
        }

        // Drag and drop handlers
        const dropZone = document.querySelector('.upload-area');
        if (dropZone) {
            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('dragover');
            });
            
            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('dragover');
            });
            
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('dragover');
                if (e.dataTransfer.files.length) {
                    this.handleFileUpload(e.dataTransfer.files[0]);
                }
            });
        }

        // Brightness control
        const brightnessSlider = document.querySelector('#brightness');
        if (brightnessSlider) {
            brightnessSlider.addEventListener('input', () => this.adjustBrightness(brightnessSlider.value));
        }

        // Contrast control
        const contrastSlider = document.querySelector('#contrast');
        if (contrastSlider) {
            contrastSlider.addEventListener('input', () => this.adjustContrast(contrastSlider.value));
        }
    }

    async handleFileUpload(file) {
        const uploadArea = document.querySelector('.upload-area');
        uploadArea.classList.add('uploading');
        
        if (!file || !file.type.startsWith('image/')) {
            alert('Please upload an image file');
            uploadArea.classList.remove('uploading');
            return;
        }

        const formData = new FormData();
        formData.append('image', file);

        try {
            const response = await fetch('/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            if (data.success) {
                await this.loadImage(data.imageUrl);
                document.querySelector('#editor-tools').style.display = 'block';
            }
        } catch (error) {
            console.error('Upload failed:', error);
            alert('Failed to upload image. Please try again.');
        } finally {
            uploadArea.classList.remove('uploading');
        }
    }

    loadImage(url) {
        return new Promise((resolve, reject) => {
            this.image.onload = () => {
                this.canvas.width = this.image.width;
                this.canvas.height = this.image.height;
                this.ctx.drawImage(this.image, 0, 0);
                resolve();
            };
            this.image.onerror = reject;
            this.image.src = url;
        });
    }

    adjustBrightness(value) {
        // Simple brightness adjustment preview
        this.ctx.filter = `brightness(${value}%)`;
        this.ctx.drawImage(this.image, 0, 0);
    }

    adjustContrast(value) {
        // Simple contrast adjustment preview
        this.ctx.filter = `contrast(${value}%)`;
        this.ctx.drawImage(this.image, 0, 0);
    }

    saveChanges() {
        const dataUrl = this.canvas.toDataURL('image/jpeg');
        const link = document.createElement('a');
        link.download = 'edited-profile-picture.jpg';
        link.href = dataUrl;
        link.click();
    }

    resetChanges() {
        document.querySelector('#brightness').value = this.originalSettings.brightness;
        document.querySelector('#contrast').value = this.originalSettings.contrast;
        this.ctx.filter = 'none';
        this.ctx.drawImage(this.image, 0, 0);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.imageEditor = new ImageEditor();
}); 