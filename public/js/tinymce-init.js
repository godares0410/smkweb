/**
 * TinyMCE Custom Initialization
 * File ini digunakan untuk menginisialisasi TinyMCE editor dengan konfigurasi custom
 * 
 * INSTRUKSI:
 * 1. Download TinyMCE dari https://www.tiny.cloud/get-tiny/self-hosted/
 * 2. Extract ke folder: public/tinymce/
 * 3. Pastikan file tinymce.min.js ada di: public/tinymce/tinymce.min.js
 * 4. Atau gunakan versi custom yang sudah Anda buat
 */

(function() {
    'use strict';

    /**
     * Initialize TinyMCE Editor
     * @param {string} selector - CSS selector untuk textarea (default: '#content')
     * @param {object} options - Opsi tambahan untuk konfigurasi
     */
    function initTinyMCE(selector, options) {
        // Default configuration
        const defaultConfig = {
            selector: selector || '#content',
            height: 500,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'code', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help | code',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
            language: 'id',
            branding: false,
            promotion: false,
            // Custom settings
            convert_urls: false,
            relative_urls: false,
            remove_script_host: false,
            // Image upload settings (jika diperlukan)
            images_upload_handler: function (blobInfo, progress) {
                return new Promise(function (resolve, reject) {
                    // Implementasi upload image jika diperlukan
                    reject('Image upload belum dikonfigurasi');
                });
            }
        };

        // Merge dengan options yang diberikan
        const config = Object.assign({}, defaultConfig, options || {});

        // Check if TinyMCE is loaded
        if (typeof tinymce === 'undefined') {
            console.error('TinyMCE tidak ditemukan. Pastikan file tinymce.min.js sudah dimuat.');
            return;
        }

        // Initialize TinyMCE
        tinymce.init(config);
    }

    // Auto-initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-initialize #content jika ada
            if (document.querySelector('#content')) {
                initTinyMCE('#content');
            }
        });
    } else {
        // DOM already loaded
        if (document.querySelector('#content')) {
            initTinyMCE('#content');
        }
    }

    // Export function untuk digunakan di file lain
    if (typeof window !== 'undefined') {
        window.initTinyMCE = initTinyMCE;
    }
})();

