document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editFieldCategoryBtn");
    const modal = document.getElementById("editFieldCategoryModal");
    const closeButtons = document.querySelectorAll(".btn-close-field-category");
    const editForm = document.getElementById("editFieldCategoryForm");
    const editName = document.getElementById("editFieldCategoryName");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const { id, name } = btn.dataset;

            editName.value = name;
            editForm.action = `/admin/field-categories/update/${id}`;

            modal.classList.remove("hidden");
            modal.classList.add("flex");
            document.body.style.overflow = "hidden";
        });
    });

    function closeModal() {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
        document.body.style.overflow = "auto";
    }

    // SEMUA tombol close
    closeButtons.forEach((btn) => {
        btn.addEventListener("click", closeModal);
    });

    // klik area luar modal
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });
});
