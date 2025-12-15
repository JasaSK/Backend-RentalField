document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editBtn");
    const modal = document.getElementById("editGalleryModal");
    const closeButtons = document.querySelectorAll(".btn-cancel-modal");
    const editForm = document.getElementById("editGalleryForm");

    const previewImg = document.getElementById("previewGalleryImage");
    const imageInput = document.getElementById("editGalleryImage");

    // buka modal
    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const { id, name, description, categoryId, image } = btn.dataset;

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_description").value = description;
            document.getElementById("edit_category").value = categoryId;

            if (image) {
                previewImg.src = image;
                previewImg.classList.remove("hidden");
            } else {
                previewImg.classList.add("hidden");
            }

            editForm.action = `/admin/galleries/update/${id}`;

            modal.classList.remove("hidden");
            modal.classList.add("flex");
            document.body.style.overflow = "hidden";
        });
    });

    // preview gambar
    imageInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewImg.classList.remove("hidden");
        }
    });

    // SATU FUNGSI CLOSE
    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        document.body.style.overflow = "auto";

        imageInput.value = "";
    }

    // semua tombol close (X & Batal)
    closeButtons.forEach((btn) => {
        btn.addEventListener("click", closeModal);
    });

    // klik background
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("image");
    const preview = document.getElementById("imagePreview");
    const placeholder = document.getElementById("uploadPlaceholder");

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
