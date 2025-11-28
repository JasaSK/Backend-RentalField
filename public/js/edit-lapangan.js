document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editFieldBtn");
    const modal = document.getElementById("editFieldModal");
    const closeModal = document.getElementById("cancelFieldEdit");
    const editForm = document.getElementById("editFieldForm");

    const previewImg = document.getElementById("editFieldPreview");
    const imageInput = document.getElementById("editFieldImage");

    const editName = document.getElementById("editFieldName");
    const editOpen = document.getElementById("editFieldOpen");
    const editClose = document.getElementById("editFieldClose");
    const editPrice = document.getElementById("editFieldPrice");
    const editDescription = document.getElementById("editFieldDescription");
    const editCategory = document.getElementById("editFieldCategory");
    const editStatus = document.getElementById("editFieldStatus");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            editName.value = btn.dataset.name;
            editOpen.value = btn.dataset.open_time
                ? btn.dataset.open_time.slice(0, 5)
                : "";
            editClose.value = btn.dataset.close_time
                ? btn.dataset.close_time.slice(0, 5)
                : "";

            editPrice.value = btn.dataset.price;
            editDescription.value = btn.dataset.description;
            editCategory.value = btn.dataset.category; // ← LANGSUNG ISI ID
            editStatus.value = btn.dataset.status;

            const image = btn.dataset.image;
            if (image) {
                previewImg.src = image;
                previewImg.classList.remove("hidden");
            } else {
                previewImg.classList.add("hidden");
            }

            editForm.action = `/admin/fields/update/${id}`;
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

    // Tombol batal
    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });

    // Klik luar modal untuk tutup
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});
