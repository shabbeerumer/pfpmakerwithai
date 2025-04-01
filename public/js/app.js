// Main application JavaScript

// Debug mode
const DEBUG = true;

// Store original click handlers
const originalClickHandlers = new WeakMap();

// Global error handling
window.onerror = function (message, source, lineno, colno, error) {
    // Log the error details
    const errorDetails = {
        message: message,
        source: source,
        line: lineno,
        column: colno,
        stack: error ? error.stack : null,
        userAgent: navigator.userAgent,
        timestamp: new Date().toISOString(),
        url: window.location.href,
        referrer: document.referrer,
        clickedElement: window._lastClickedElement || null
    };

    // Log to console
    console.error('JavaScript Error:', errorDetails);

    // You can also send this to your server for logging
    try {
        fetch('/log-error', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
            },
            body: JSON.stringify(errorDetails)
        }).catch(err => console.error('Failed to send error log:', err));
    } catch (e) {
        console.error('Error while sending error log:', e);
    }

    return false; // Let the error propagate
};

// Enhanced click tracking
document.addEventListener('click', function (e) {
    // Don't interfere with navigation links
    if (e.target.tagName === 'A' || e.target.closest('a')) {
        return true;
    }

    // Track other clicks
    if (DEBUG) {
        console.log('Non-navigation click:', {
            target: e.target,
            type: e.type,
            defaultPrevented: e.defaultPrevented
        });
    }
});

// Monitor navigation events
window.addEventListener('beforeunload', function (e) {
    if (DEBUG) {
        console.log('Navigation attempted to:', window.location.href);
        console.log('Last clicked element:', window._lastClickedElement);
    }
});

// Monitor history changes
window.addEventListener('popstate', function (e) {
    if (DEBUG) {
        console.log('History state changed:', {
            state: e.state,
            url: window.location.href
        });
    }
});

// Catch unhandled promise rejections
window.addEventListener('unhandledrejection', function (event) {
    console.error('Unhandled Promise Rejection:', {
        reason: event.reason,
        lastClicked: window._lastClickedElement
    });
});

// Initialize only what's needed for the current page
document.addEventListener('DOMContentLoaded', function () {
    if (DEBUG) {
        console.log('Page loaded:', {
            url: window.location.href,
            pathname: window.location.pathname
        });
    }

    // Initialize only what's needed for the current page
    if (document.querySelector('#dropZone')) {
        window.imageProcessor = new ImageProcessor();
    }

    // Initialize tooltips only if needed
    const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (tooltipElements.length > 0) {
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
    }

    // Initialize image handling
    initializeImageHandling();

    // Handle file uploads
    const uploadForm = document.querySelector('#uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', handleUpload);
    }

    // Handle drag and drop
    const uploadArea = document.querySelector('.upload-area');
    if (uploadArea) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        uploadArea.addEventListener('drop', handleDrop, false);
    }

    // Add lazy loading for images
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    if ('loading' in HTMLImageElement.prototype) {
        lazyImages.forEach(img => {
            img.loading = 'lazy';
        });
    } else {
        // Fallback for browsers that don't support lazy loading
        const script = document.createElement('script');
        script.src = '/js/lazysizes.min.js';
        document.body.appendChild(script);
    }
});

class ImageProcessor {
    constructor() {
        this.setupCSRFToken();
        this.initializeElements();
        this.initializeEventListeners();
        this.removedBackgroundImage = null;
    }

    setupCSRFToken() {
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        axios.defaults.headers.common['X-CSRF-TOKEN'] = this.csrfToken;
    }

    initializeElements() {
        this.dropZone = document.querySelector('#dropZone');
        this.fileInput = document.querySelector('#file-input');
        this.preview = document.querySelector('#image-preview');
        this.uploadButton = document.querySelector('#uploadButton');
        this.uploadForm = document.querySelector('#uploadForm');
        this.originalImage = document.querySelector('#originalImage');
        this.processedImage = document.querySelector('#processedImage');
        this.downloadButton = document.querySelector('#downloadButton');
        this.tryAgainButton = document.querySelector('#tryAgainButton');
        this.progressBar = document.querySelector('.progress-bar');
        this.uploadProgress = document.querySelector('#uploadProgress');
        this.backgroundOptions = document.querySelector('#backgroundOptions');
        this.backgroundOptionElements = document.querySelectorAll('.background-option');

        if (!this.dropZone || !this.fileInput || !this.preview) {
            console.warn('Some elements not found. Make sure all required elements exist.');
            return;
        }

        // Initialize button handlers
        this.uploadButton.addEventListener('click', () => this.fileInput.click());
        this.tryAgainButton.addEventListener('click', () => this.resetUpload());

        // Initialize background options
        this.backgroundOptionElements.forEach(option => {
            option.addEventListener('click', () => this.applyBackground(option));
        });
    }

    initializeEventListeners() {
        if (!this.dropZone || !this.fileInput) return;

        // Handle drag and drop
        this.dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.dropZone.classList.add('border-primary');
        });

        this.dropZone.addEventListener('dragleave', () => {
            this.dropZone.classList.remove('border-primary');
        });

        this.dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            this.dropZone.classList.remove('border-primary');
            const files = e.dataTransfer.files;
            if (files.length) {
                this.handleFile(files[0]);
            }
        });

        // Handle file input change
        this.fileInput.addEventListener('change', (e) => {
            if (e.target.files.length) {
                this.handleFile(e.target.files[0]);
            }
        });
    }

    resetUpload() {
        this.uploadForm.classList.remove('d-none');
        this.preview.classList.add('d-none');
        this.backgroundOptions.classList.add('d-none');
        this.fileInput.value = '';
        this.uploadProgress.classList.add('d-none');
        this.progressBar.style.width = '0%';
        this.removedBackgroundImage = null;
        this.backgroundOptionElements.forEach(opt => opt.classList.remove('selected'));
    }

    async handleFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('Please upload an image file');
            return;
        }

        // Validate file type and size
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 5 * 1024 * 1024; // 5MB

        if (!validTypes.includes(file.type)) {
            alert('Please upload a valid image file (PNG, JPEG, JPG)');
            return;
        }

        if (file.size > maxSize) {
            alert('File size should not exceed 5MB');
            return;
        }

        // Show progress
        this.uploadProgress.classList.remove('d-none');
        this.progressBar.style.width = '0%';

        try {
            const formData = new FormData();
            formData.append('image', file);

            // Simulate upload progress
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += 5;
                if (progress <= 90) {
                    this.progressBar.style.width = progress + '%';
                }
            }, 100);

            // Upload image
            let uploadResponse;
            try {
                uploadResponse = await fetch('/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken
                    }
                });

                if (!uploadResponse.ok) {
                    const errorData = await uploadResponse.json();
                    throw new Error(errorData.message || `Upload failed with status: ${uploadResponse.status}`);
                }
            } catch (uploadError) {
                throw new Error(`Network error during upload: ${uploadError.message}`);
            }

            const uploadResult = await uploadResponse.json();
            if (!uploadResult.success) throw new Error(uploadResult.message || 'Upload failed');

            // Show original image first
            this.uploadProgress.classList.add('d-none');
            this.uploadForm.classList.add('d-none');
            this.preview.classList.remove('d-none');
            this.originalImage.src = URL.createObjectURL(file);

            // Show processing state
            this.processedImage.src = '/images/processing.gif';

            // Remove background
            let removeResponse;
            try {
                removeResponse = await fetch('/remove-bg', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken
                    },
                    body: JSON.stringify({
                        image: uploadResult.url
                    })
                });

                if (!removeResponse.ok) {
                    const errorData = await removeResponse.json();
                    throw new Error(errorData.message || `Background removal failed with status: ${removeResponse.status}`);
                }
            } catch (removeError) {
                throw new Error(`Network error during background removal: ${removeError.message}`);
            }

            const removeResult = await removeResponse.json();
            if (!removeResult.success) throw new Error(removeResult.message || 'Background removal failed');

            // Store the removed background image for later use
            this.removedBackgroundImage = removeResult.url;

            // Complete progress and show result
            clearInterval(progressInterval);
            this.progressBar.style.width = '100%';
            this.processedImage.src = removeResult.url;

            // Show background options
            this.backgroundOptions.classList.remove('d-none');

            // Update background preview cards with the processed image
            this.updateBackgroundPreviews(removeResult.url);

            // Setup download button
            this.setupDownloadButton(removeResult.url);

        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'An unexpected error occurred. Please try again.');
            this.uploadProgress.classList.add('d-none');
            this.progressBar.style.width = '0%';
            // Reset the view on error
            this.preview.classList.add('d-none');
            this.uploadForm.classList.remove('d-none');
            if (this.processedImage) {
                this.processedImage.src = '';
            }
        } finally {
            clearInterval(progressInterval);
        }
    }

    updateBackgroundPreviews(processedImageUrl) {
        const backgroundOptions = document.querySelectorAll('.background-option');
        backgroundOptions.forEach(option => {
            const preview = option.querySelector('.background-preview');
            const bgType = option.dataset.bg;

            // Clear any existing content
            preview.innerHTML = '';

            // Create and add the preview image
            const img = document.createElement('img');
            img.src = processedImageUrl;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'contain';
            img.style.position = 'absolute';
            img.style.top = '50%';
            img.style.left = '50%';
            img.style.transform = 'translate(-50%, -50%)';

            // Set background based on type
            if (bgType === 'transparent') {
                preview.classList.add('transparent-bg');
            } else if (bgType === 'solid-white') {
                preview.style.backgroundColor = '#ffffff';
            } else if (bgType.startsWith('gradient-')) {
                preview.classList.add(bgType);
            } else if (bgType !== 'custom-bg') {
                // For predefined backgrounds (office, studio, nature, city)
                preview.style.backgroundImage = `url('/images/backgrounds/${bgType}.jpg')`;
            }

            // Add the image on top
            preview.appendChild(img);
        });
    }

    async applyBackground(optionElement) {
        try {
            // Remove selection from all options
            this.backgroundOptionElements.forEach(opt => opt.classList.remove('selected'));

            // Add selection to clicked option
            optionElement.classList.add('selected');

            const bgType = optionElement.dataset.bg;

            if (!this.removedBackgroundImage) {
                throw new Error('No processed image available');
            }

            if (bgType === 'custom-bg') {
                // Create a file input for custom background
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = (e) => this.handleCustomBackground(e.target.files[0]);
                input.click();
                return;
            }

            // Show loading state
            this.processedImage.src = '/images/processing.gif';

            const response = await fetch('/apply-background', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    image: this.removedBackgroundImage,
                    background: bgType
                })
            });

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Server response:', errorText);
                throw new Error('Failed to apply background. Server returned: ' + response.status);
            }

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message || 'Failed to apply background');
            }

            // Update the preview
            this.processedImage.src = result.url;

            // Update download button
            this.setupDownloadButton(result.url);

        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Failed to apply background. Please try again.');
            optionElement.classList.remove('selected');

            // Restore the previous image if there was an error
            if (this.removedBackgroundImage) {
                this.processedImage.src = this.removedBackgroundImage;
            }
        }
    }

    async handleCustomBackground(file) {
        if (!file) return;

        try {
            const formData = new FormData();
            formData.append('image', this.removedBackgroundImage);
            formData.append('background', file);

            const response = await fetch('/apply-custom-background', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken
                }
            });

            const result = await response.json();
            if (!result.success) throw new Error(result.message || 'Failed to apply custom background');

            // Update the preview
            this.processedImage.src = result.url;

            // Update download button
            this.setupDownloadButton(result.url);

        } catch (error) {
            console.error('Error:', error);
            alert(error.message || 'Failed to apply custom background. Please try again.');
        }
    }

    setupDownloadButton(imageUrl) {
        this.downloadButton.onclick = () => {
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = 'processed_image.png';
            link.click();
        };
    }

    displayPreview(imageUrl) {
        // Ensure URL uses forward slashes
        const normalizedUrl = imageUrl.replace(/\\/g, '/');

        this.preview.innerHTML = `
            <img src="${normalizedUrl}" class="img-fluid" alt="Preview">
            <div class="mt-3">
                <button class="btn btn-primary" onclick="imageProcessor.removeBackground()">
                    Remove Background
                </button>
                <button class="btn btn-secondary" onclick="imageProcessor.enhance()">
                    Enhance Photo
                </button>
            </div>
        `;
    }

    async removeBackground() {
        try {
            const img = this.preview.querySelector('img');
            if (!img) return;

            // Show loading state
            const button = this.preview.querySelector('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            button.disabled = true;

            // Call the remove background API
            const response = await fetch('/remove-bg', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    image: img.src
                })
            });

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message || 'Failed to remove background');
            }

            // Update the preview with the processed image
            img.src = data.url;

            // Reset button state
            button.innerHTML = originalText;
            button.disabled = false;

        } catch (error) {
            console.error('Background removal failed:', error);
            alert('Failed to remove background. Please try again.');

            // Reset button state
            const button = this.preview.querySelector('button');
            button.innerHTML = 'Remove Background';
            button.disabled = false;
        }
    }

    async applyFilter(filterType) {
        // Instagram-like filters
    }

    async adjustImage(settings) {
        // Brightness, contrast, saturation
    }

    async cropImage(dimensions) {
        // Smart cropping for different platforms
    }

    async generateVariations() {
        // AI-powered variations
    }
}

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

function highlight(e) {
    this.classList.add('dragover');
}

function unhighlight(e) {
    this.classList.remove('dragover');
}

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    handleFiles(files);
}

function handleFiles(files) {
    // Handle file upload logic
}

function handleUpload(e) {
    e.preventDefault();
    // Handle form submission
}

// Add intersection observer for animations
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-on-scroll').forEach((elem) => {
    observer.observe(elem);
});

// Enhanced image error handling
function handleImageError(img) {
    img.onerror = null; // Prevent infinite loop
    img.src = '/images/placeholder.svg';
    img.classList.add('img-error');

    // Log error for monitoring
    console.warn(`Image failed to load: ${img.src}`);

    // Try to reload after 2 seconds
    setTimeout(() => {
        const originalSrc = img.getAttribute('data-original-src');
        if (originalSrc) {
            img.src = originalSrc;
        }
    }, 2000);
}

// Enhanced image loading and error handling
function initializeImageHandling() {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        // Save original source
        img.setAttribute('data-original-src', img.src);

        // Add loading attribute if not present
        if (!img.hasAttribute('loading')) {
            img.setAttribute('loading', 'lazy');
        }

        // Add error handling
        img.onerror = () => handleImageError(img);
    });
}

// Cleanup function to remove any problematic event listeners
function cleanupEventListeners() {
    const elements = document.querySelectorAll('a, button, [onclick]');
    elements.forEach(element => {
        const clone = element.cloneNode(true);
        element.parentNode.replaceChild(clone, element);
    });
} 