document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editGalleryCategoryBtn");
    const modal = document.getElementById("editGalleryCategoryModal");
    const closeModal = document.getElementById("cancelGalleryCategoryEdit");
    const editForm = document.getElementById("editGalleryCategoryForm");
    const editName = document.getElementById("editGalleryCategoryName");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            editName.value = btn.dataset.name;

            editForm.action = `/admin/gallery-categories/update/${id}`;
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

    // Tombol batal
    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });
    console.log(modal);

    // Klik luar modal untuk tutup
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});
