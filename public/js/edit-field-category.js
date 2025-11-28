document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editFieldCategoryBtn");
    const modal = document.getElementById("editFieldCategoryModal");
    const closeModal = document.getElementById("cancelFieldCategoryEdit");
    const editForm = document.getElementById("editFieldCategoryForm");

    const editName = document.getElementById("editFieldCategoryName");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            editName.value = btn.dataset.name;

            editForm.action = `/admin/field-categories/update/${id}`;
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
