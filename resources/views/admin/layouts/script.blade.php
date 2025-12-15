{{-- Custom JS --}}
<script src="{{ asset('js/edit-banner.js') }}"></script>
<script src="{{ asset('js/edit-gallery.js') }}"></script>
<script src="{{ asset('js/edit-lapangan.js') }}"></script>
<script src="{{ asset('js/edit-field-category.js') }}"></script>
<script src="{{ asset('js/edit-gallery-category.js') }}"></script>
<script src="{{ asset('js/edit-refund.js') }}"></script>
<script src="{{ asset('js/edit-maintenance.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/verifyTicket.js') }}"></script>

{{-- Library --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        /* ==========================
           SWEETALERT GLOBAL CONFIG
        ========================== */
        const SwalConfig = {
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
            customClass: {
                popup: 'custom-swal-popup',
                title: 'custom-swal-title',
                htmlContainer: 'custom-swal-content',
                timerProgressBar: 'custom-swal-progress'
            }
        };

        /* ==========================
           TOAST STYLES
        ========================== */
        const toastStyles = `
            <style>
                /* Custom SweetAlert Toast Styles */
                .swal2-container {
                    z-index: 10000 !important;
                }
                
                .custom-swal-popup {
                    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
                    border-radius: 12px !important;
                    border: 1px solid rgba(16, 185, 129, 0.2);
                    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
                    backdrop-filter: blur(10px);
                    padding: 1.25rem !important;
                    min-width: 350px;
                }
                
                .custom-swal-title {
                    color: #1f2937 !important;
                    font-weight: 600 !important;
                    font-size: 1.125rem !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    margin-bottom: 0.5rem !important;
                }
                
                .custom-swal-content {
                    color: #4b5563 !important;
                    font-size: 0.9375rem !important;
                    line-height: 1.5 !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    padding: 0 !important;
                }
                
                .custom-swal-progress {
                    background: linear-gradient(90deg, #10b981 0%, #059669 100%) !important;
                    height: 3px !important;
                    border-radius: 3px;
                }
                
                /* Success Toast */
                .swal2-icon-success {
                    border-color: #10b981 !important;
                    color: #10b981 !important;
                }
                
                .swal2-icon-success .swal2-success-ring {
                    border: 0.25em solid rgba(16, 185, 129, 0.2) !important;
                }
                
                .swal2-icon-success [class^="swal2-success-line"] {
                    background-color: #10b981 !important;
                }
                
                /* Error Toast */
                .swal2-icon-error {
                    border-color: #ef4444 !important;
                    color: #ef4444 !important;
                }
                
                .swal2-icon-error .swal2-x-mark-line-left,
                .swal2-icon-error .swal2-x-mark-line-right {
                    background-color: #ef4444 !important;
                }
                
                /* Warning Toast */
                .swal2-icon-warning {
                    border-color: #f59e0b !important;
                    color: #f59e0b !important;
                }
                
                /* Info Toast */
                .swal2-icon-info {
                    border-color: #3b82f6 !important;
                    color: #3b82f6 !important;
                }
                
                /* Success Toast with Gradient Border */
                .swal2-popup.swal2-toast.success-toast {
                    border-left: 4px solid #10b981;
                    border-image: linear-gradient(to bottom, #10b981, #059669) 1;
                }
                
                /* Error Toast with Gradient Border */
                .swal2-popup.swal2-toast.error-toast {
                    border-left: 4px solid #ef4444;
                    border-image: linear-gradient(to bottom, #ef4444, #dc2626) 1;
                }
                
                /* Warning Toast with Gradient Border */
                .swal2-popup.swal2-toast.warning-toast {
                    border-left: 4px solid #f59e0b;
                    border-image: linear-gradient(to bottom, #f59e0b, #d97706) 1;
                }
                
                /* Info Toast with Gradient Border */
                .swal2-popup.swal2-toast.info-toast {
                    border-left: 4px solid #3b82f6;
                    border-image: linear-gradient(to bottom, #3b82f6, #1d4ed8) 1;
                }
                
                /* Dark Mode Support */
                @media (prefers-color-scheme: dark) {
                    .custom-swal-popup {
                        background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
                        border: 1px solid rgba(16, 185, 129, 0.3) !important;
                        color: #f3f4f6 !important;
                    }
                    
                    .custom-swal-title {
                        color: #f9fafb !important;
                    }
                    
                    .custom-swal-content {
                        color: #d1d5db !important;
                    }
                }
                
                /* Responsive Design */
                @media (max-width: 640px) {
                    .custom-swal-popup {
                        min-width: 280px !important;
                        margin: 0.5rem !important;
                        font-size: 0.875rem !important;
                    }
                    
                    .custom-swal-title {
                        font-size: 1rem !important;
                    }
                }
            </style>
        `;

        // Inject styles
        document.head.insertAdjacentHTML('beforeend', toastStyles);

        /* ==========================
           TOAST HELPER FUNCTIONS
        ========================== */
        const Toast = {
            success: (title, text = '', timer = 3000) => {
                return Swal.fire({
                    ...SwalConfig,
                    icon: 'success',
                    title,
                    text,
                    timer,
                    customClass: {
                        ...SwalConfig.customClass,
                        popup: `${SwalConfig.customClass.popup} success-toast`
                    }
                });
            },

            error: (title, text = '', timer = 4000) => {
                return Swal.fire({
                    ...SwalConfig,
                    icon: 'error',
                    title,
                    text,
                    timer,
                    customClass: {
                        ...SwalConfig.customClass,
                        popup: `${SwalConfig.customClass.popup} error-toast`
                    }
                });
            },

            warning: (title, text = '', timer = 3500) => {
                return Swal.fire({
                    ...SwalConfig,
                    icon: 'warning',
                    title,
                    text,
                    timer,
                    customClass: {
                        ...SwalConfig.customClass,
                        popup: `${SwalConfig.customClass.popup} warning-toast`
                    }
                });
            },

            info: (title, text = '', timer = 3000) => {
                return Swal.fire({
                    ...SwalConfig,
                    icon: 'info',
                    title,
                    text,
                    timer,
                    customClass: {
                        ...SwalConfig.customClass,
                        popup: `${SwalConfig.customClass.popup} info-toast`
                    }
                });
            }
        };

        /* ==========================
           MODAL HELPER FUNCTIONS
        ========================== */
        const Modal = {
            confirm: (options = {}) => {
                const defaultOptions = {
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin melanjutkan?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        popup: 'custom-modal-popup',
                        title: 'custom-modal-title',
                        htmlContainer: 'custom-modal-content',
                        confirmButton: 'custom-confirm-btn',
                        cancelButton: 'custom-cancel-btn',
                        actions: 'custom-modal-actions'
                    }
                };

                // Merge options
                const mergedOptions = {
                    ...defaultOptions,
                    ...options
                };

                return Swal.fire(mergedOptions);
            },

            delete: (options = {}) => {
                return Modal.confirm({
                    title: 'Hapus Data?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, hapus!',
                    ...options
                });
            },

            logout: (options = {}) => {
                return Modal.confirm({
                    title: 'Logout?',
                    text: 'Anda akan keluar dari sistem.',
                    icon: 'question',
                    confirmButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, logout',
                    ...options
                });
            },

            reject: (options = {}) => {
                return Modal.confirm({
                    title: 'Tolak Permintaan?',
                    text: 'Permintaan akan ditolak dan tidak dapat dibatalkan.',
                    icon: 'error',
                    confirmButtonColor: '#f59e0b',
                    confirmButtonText: 'Ya, tolak',
                    ...options
                });
            }
        };

        /* ==========================
           FLASH MESSAGE HANDLING
        ========================== */
        @if (session('success'))
            Toast.success('Sukses!', "{{ session('success') }}");
        @endif

        @if (session('error'))
            Toast.error('Error!', "{{ session('error') }}", 4000);
        @endif

        @if (session('warning'))
            Toast.warning('Peringatan!', "{{ session('warning') }}");
        @endif

        @if (session('info'))
            Toast.info('Informasi', "{{ session('info') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                Toast.error('Validasi Error', "{{ $error }}", 4000);
            @endforeach
        @endif

        /* ==========================
           DELETE CONFIRMATION
        ========================== */
        document.querySelectorAll('form.deleteForm').forEach((form) => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const customOptions = {};

                // Get custom options from data attributes
                if (form.dataset.title) customOptions.title = form.dataset.title;
                if (form.dataset.text) customOptions.text = form.dataset.text;
                if (form.dataset.icon) customOptions.icon = form.dataset.icon;
                if (form.dataset.confirmcolor) customOptions.confirmButtonColor = form.dataset
                    .confirmcolor;
                if (form.dataset.confirm) customOptions.confirmButtonText = form.dataset
                .confirm;
                if (form.dataset.cancel) customOptions.cancelButtonText = form.dataset.cancel;

                Modal.delete(customOptions).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading before submit
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Mohon tunggu sebentar',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
                });
            });
        });

        /* ==========================
           LOGOUT CONFIRMATION
        ========================== */
        document.querySelectorAll('form.logout').forEach((form) => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const customOptions = {};

                if (form.dataset.title) customOptions.title = form.dataset.title;
                if (form.dataset.text) customOptions.text = form.dataset.text;
                if (form.dataset.confirm) customOptions.confirmButtonText = form.dataset
                .confirm;

                Modal.logout(customOptions).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Sedang keluar dari sistem',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
                });
            });
        });

        /* ==========================
           REJECT CONFIRMATION
        ========================== */
        document.querySelectorAll('form.rejected').forEach((form) => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const customOptions = {};

                if (form.dataset.title) customOptions.title = form.dataset.title;
                if (form.dataset.text) customOptions.text = form.dataset.text;
                if (form.dataset.confirm) customOptions.confirmButtonText = form.dataset
                .confirm;

                Modal.reject(customOptions).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Memproses...',
                            text: 'Sedang menolak permintaan',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        form.submit();
                    }
                });
            });
        });

        /* ==========================
           GLOBAL CONFIRMATION MODAL
           (Can be called from anywhere)
        ========================== */
        window.showConfirm = function(options) {
            return Modal.confirm(options);
        };

        window.showDeleteConfirm = function(options) {
            return Modal.delete(options);
        };

        /* ==========================
           GLOBAL TOAST FUNCTIONS
           (Can be called from anywhere)
        ========================== */
        window.showToast = {
            success: (title, text = '') => Toast.success(title, text),
            error: (title, text = '') => Toast.error(title, text),
            warning: (title, text = '') => Toast.warning(title, text),
            info: (title, text = '') => Toast.info(title, text)
        };

        /* ==========================
           ADDITIONAL MODAL STYLES
        ========================== */
        const modalStyles = `
            <style>
                /* Modal Styles */
                .custom-modal-popup {
                    background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
                    border-radius: 16px !important;
                    border: 1px solid rgba(16, 185, 129, 0.2);
                    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
                    padding: 2rem !important;
                    max-width: 500px !important;
                    backdrop-filter: blur(10px);
                }
                
                .custom-modal-title {
                    color: #1f2937 !important;
                    font-weight: 700 !important;
                    font-size: 1.5rem !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                    margin-bottom: 1rem !important;
                }
                
                .custom-modal-content {
                    color: #4b5563 !important;
                    font-size: 1rem !important;
                    line-height: 1.6 !important;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                }
                
                .custom-modal-actions {
                    margin-top: 1.5rem !important;
                    gap: 0.75rem !important;
                }
                
                .custom-confirm-btn {
                    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
                    border: none !important;
                    border-radius: 8px !important;
                    padding: 0.75rem 1.5rem !important;
                    font-weight: 600 !important;
                    font-size: 0.9375rem !important;
                    transition: all 0.2s ease !important;
                }
                
                .custom-confirm-btn:hover {
                    transform: translateY(-2px) !important;
                    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3) !important;
                }
                
                .custom-cancel-btn {
                    background: #f3f4f6 !important;
                    color: #4b5563 !important;
                    border: 1px solid #e5e7eb !important;
                    border-radius: 8px !important;
                    padding: 0.75rem 1.5rem !important;
                    font-weight: 500 !important;
                    font-size: 0.9375rem !important;
                    transition: all 0.2s ease !important;
                }
                
                .custom-cancel-btn:hover {
                    background: #e5e7eb !important;
                    transform: translateY(-1px) !important;
                }
                
                /* Dark Mode for Modals */
                @media (prefers-color-scheme: dark) {
                    .custom-modal-popup {
                        background: linear-gradient(135deg, #1f2937 0%, #111827 100%) !important;
                        border: 1px solid rgba(16, 185, 129, 0.3) !important;
                    }
                    
                    .custom-modal-title {
                        color: #f9fafb !important;
                    }
                    
                    .custom-modal-content {
                        color: #d1d5db !important;
                    }
                    
                    .custom-cancel-btn {
                        background: #374151 !important;
                        color: #d1d5db !important;
                        border: 1px solid #4b5563 !important;
                    }
                    
                    .custom-cancel-btn:hover {
                        background: #4b5563 !important;
                    }
                }
                
                /* Loading Overlay */
                .swal2-loading {
                    border-color: #10b981 transparent #10b981 transparent !important;
                }
            </style>
        `;

        // Inject modal styles
        document.head.insertAdjacentHTML('beforeend', modalStyles);

        /* ==========================
           AUTO-HIDE ALERTS AFTER SUBMIT
        ========================== */
        document.addEventListener('submit', function(e) {
            const form = e.target;

            // Only for forms that are not confirmation forms
            if (!form.classList.contains('deleteForm') &&
                !form.classList.contains('logout') &&
                !form.classList.contains('rejected')) {

                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    text: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });

        /* ==========================
           ENHANCE SWAL BUTTONS
        ========================== */
        // Wait for swal to be ready
        setTimeout(() => {
            // Add ripple effect to swal buttons
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('swal2-confirm') ||
                    e.target.classList.contains('swal2-cancel')) {

                    const btn = e.target;
                    const ripple = document.createElement('span');
                    const rect = btn.getBoundingClientRect();

                    ripple.style.width = ripple.style.height =
                        `${Math.max(rect.width, rect.height)}px`;
                    ripple.style.left =
                        `${e.clientX - rect.left - Math.max(rect.width, rect.height) / 2}px`;
                    ripple.style.top =
                        `${e.clientY - rect.top - Math.max(rect.width, rect.height) / 2}px`;
                    ripple.classList.add('ripple-effect');

                    btn.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                }
            });

            // Add ripple effect styles
            const rippleStyles = `
                <style>
                    .ripple-effect {
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.3);
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        pointer-events: none;
                    }
                    
                    .swal2-confirm, .swal2-cancel {
                        overflow: hidden !important;
                        position: relative !important;
                    }
                    
                    @keyframes ripple {
                        to {
                            transform: scale(4);
                            opacity: 0;
                        }
                    }
                </style>
            `;

            document.head.insertAdjacentHTML('beforeend', rippleStyles);
        }, 1000);

    });
</script>
