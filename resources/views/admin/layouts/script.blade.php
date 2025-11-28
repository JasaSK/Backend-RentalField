<!-- SweetAlert2 CDN -->

<script src="{{ asset('js/edit-banner.js') }}"></script>
<script src="{{ asset('js/edit-gallery.js') }}"></script>
<script src="{{ asset('js/edit-lapangan.js') }}"></script>
<script src="{{ asset('js/edit-field-category.js') }}"></script>
<script src="{{ asset('js/edit-gallery-category.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

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

    });

    document.addEventListener("DOMContentLoaded", function() {

        const deleteForms = document.querySelectorAll("form.deleteForm");

        deleteForms.forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault(); // cegah submit langsung

                Swal.fire({
                    title: "Hapus kategori?",
                    text: "Aksi ini tidak bisa dibatalkan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // submit jika setuju
                    }
                });

            });
        });

    });
</script>
