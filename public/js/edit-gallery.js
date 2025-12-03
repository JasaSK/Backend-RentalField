document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editBtn");
    const modal = document.getElementById("editGalleryModal");
    const closeModal = document.getElementById("closeGalleryModal");
    const editForm = document.getElementById("editGalleryForm");

    const previewImg = document.getElementById("previewGalleryImage");
    const imageInput = document.getElementById("editGalleryImage");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const description = btn.dataset.description;
            let categoryId = btn.dataset.categoryId; // pakai let agar bisa diganti
            const image = btn.dataset.image;

            // Isi form
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_description").value = description;
            document.getElementById("edit_category").value = categoryId;

            // Preview gambar
            if (image) {
                previewImg.src = image;
                previewImg.classList.remove("hidden");
            } else {
                previewImg.classList.add("hidden");
            }

            // Set action
            editForm.action = `/admin/galleries/update/${id}`;

            // Tampilkan modal
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

    // Preview gambar baru
    imageInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            previewImg.classList.remove("hidden");
        }
    });

    // Close modal
    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });

    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});
