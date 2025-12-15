// Modal functionality
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("editFieldModal");
    const modalOverlay = document.getElementById("modalOverlay");
    const cancelButtons = document.querySelectorAll(
        "#cancelFieldEdit, #modalCancel"
    );
    const editButtons = document.querySelectorAll(".editFieldBtn");
    const searchInput = document.getElementById("searchField");
    const tableRows = document.querySelectorAll("#fieldTableBody tr");
    const editImageInput = document.getElementById("editFieldImage");

    // Open modal on edit button click
    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const name = this.getAttribute("data-name");
            const image = this.getAttribute("data-image");
            const openTime = this.getAttribute("data-open_time");
            const closeTime = this.getAttribute("data-close_time");
            const description = this.getAttribute("data-description");
            const price = this.getAttribute("data-price");
            const category = this.getAttribute("data-category");
            const status = this.getAttribute("data-status");

            // Set form action
            document.getElementById(
                "editFieldForm"
            ).action = `/admin/fields/update/${id}`;

            // Set form values
            document.getElementById("editFieldName").value = name;
            document.getElementById("editFieldPreview").src = image;
            document.getElementById("editFieldOpen").value = openTime;
            document.getElementById("editFieldClose").value = closeTime;
            document.getElementById("editFieldDescription").value =
                description || "";
            document.getElementById("editFieldPrice").value = price;
            document.getElementById("editFieldCategory").value = category;
            document.getElementById("editFieldStatus").value = status;

            // Show current image
            if (image) {
                document
                    .getElementById("currentImageContainer")
                    .classList.remove("hidden");
            } else {
                document
                    .getElementById("currentImageContainer")
                    .classList.add("hidden");
            }

            // Show modal
            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        });
    });

    // Close modal
    function closeModal() {
        modal.classList.add("hidden");
        document.body.style.overflow = "auto";
    }

    cancelButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    modalOverlay.addEventListener("click", closeModal);

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach((row) => {
                const fieldName = row.getAttribute("data-field-name") || "";
                if (fieldName.includes(searchTerm)) {
                    row.classList.remove("hidden");
                } else {
                    row.classList.add("hidden");
                }
            });
        });
    }

    // Image preview for edit modal
    if (editImageInput) {
        editImageInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById("editFieldPreview").src =
                        e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});

// Delete confirmation
// function confirmDelete(event) {
//     const form = event.target.closest("form");
//     event.preventDefault();

//     Swal.fire({
//         title: "Apakah Anda yakin?",
//         text: "Lapangan ini akan dihapus permanen!",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#d33",
//         cancelButtonColor: "#3085d6",
//         confirmButtonText: "Ya, hapus!",
//         cancelButtonText: "Batal",
//         reverseButtons: true,
//     }).then((result) => {
//         if (result.isConfirmed) {
//             form.submit();
//         }
//     });

//     return false;
// }

// Image modal functions
function openImageModal(src) {
    document.getElementById("modalImage").src = src;
    document.getElementById("imageModal").classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function closeImageModal() {
    document.getElementById("imageModal").classList.add("hidden");
    document.body.style.overflow = "auto";
}

// Add SweetAlert2 if not already loaded
if (typeof Swal === "undefined") {
    const script = document.createElement("script");
    script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@11";
    document.head.appendChild(script);
}

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("fieldImageInput");
    const preview = document.getElementById("fieldImagePreview");
    const placeholder = document.getElementById("fieldUploadPlaceholder");

    input.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;

        if (!file.type.startsWith("image/")) {
            alert("File harus berupa gambar!");
            input.value = "";
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.classList.remove("hidden");
        placeholder.classList.add("hidden");
    });
});
