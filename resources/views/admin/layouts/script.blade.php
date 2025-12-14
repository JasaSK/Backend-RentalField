{{-- Custom JS --}}
<script src="{{ asset('js/edit-banner.js') }}"></script>
<script src="{{ asset('js/edit-gallery.js') }}"></script>
<script src="{{ asset('js/edit-lapangan.js') }}"></script>
<script src="{{ asset('js/edit-field-category.js') }}"></script>
<script src="{{ asset('js/edit-gallery-category.js') }}"></script>
<script src="{{ asset('js/edit-refund.js') }}"></script>
<script src="{{ asset('js/edit-maintenance.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>

{{-- Library --}}
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ==========================
       SWEETALERT FLASH MESSAGE
    ========================== */
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: "{{ session('success') }}",
            timer: 3000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            timer: 3000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true
        });
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ $error }}",
                timer: 4000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        @endforeach
    @endif


    /* ==========================
       DELETE CONFIRMATION
    ========================== */
    document.querySelectorAll('form.deleteForm').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: form.dataset.title || 'Hapus Data?',
                text: form.dataset.text || 'Aksi ini tidak dapat dibatalkan!',
                icon: form.dataset.icon || 'warning',
                showCancelButton: true,
                confirmButtonColor: form.dataset.confirmcolor || '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: form.dataset.confirm || 'Ya, hapus!',
                cancelButtonText: form.dataset.cancel || 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });


    /* ==========================
       LOGOUT CONFIRMATION
    ========================== */
    document.querySelectorAll('form.logout').forEach((form) => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: form.dataset.title || 'Logout?',
                text: form.dataset.text || 'Aksi ini tidak dapat dibatalkan!',
                icon: form.dataset.icon || 'warning',
                showCancelButton: true,
                confirmButtonColor: form.dataset.confirmcolor || '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: form.dataset.confirm || 'Ya, logout!',
                cancelButtonText: form.dataset.cancel || 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });


    /* ==========================
       SIDEBAR HAMBURGER + X
    ========================== */
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const hamburgerBtn = document.getElementById('hamburger');
    const iconHamburger = document.getElementById('icon-hamburger');
    const iconClose = document.getElementById('icon-close');

    if (sidebar && overlay && hamburgerBtn) {

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            iconHamburger.classList.add('hidden');
            iconClose.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            iconHamburger.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }

        hamburgerBtn.addEventListener('click', function () {
            sidebar.classList.contains('-translate-x-full')
                ? openSidebar()
                : closeSidebar();
        });

        overlay.addEventListener('click', closeSidebar);
    }

});
</script>
