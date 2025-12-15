document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("editGalleryCategoryModal");
    const closeButtons = document.querySelectorAll(
        ".btn-close-gallery-category"
    );
    const overlay = modal.querySelector(".modal-overlay");
    const editButtons = document.querySelectorAll(".editGalleryCategoryBtn");
    const editForm = document.getElementById("editGalleryCategoryForm");
    const modalPanel = modal.querySelector(".relative");

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const { id, name } = this.dataset;

            editForm.action = `/admin/gallery-categories/update/${id}`;
            document.getElementById("editGalleryCategoryName").value = name;

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

    closeButtons.forEach((btn) => {
        btn.addEventListener("click", closeModal);
    });

    overlay.addEventListener("click", closeModal);

    // ⛔ STOP bubbling supaya submit bisa jalan
    modalPanel.addEventListener("click", function (e) {
        e.stopPropagation();
    });
});
