document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editMaintenanceBtn");
    const editModal = document.getElementById("editMaintenanceModal");
    const modalContent = document.getElementById("modalContent");
    const closeButtons = document.querySelectorAll(
        "#closeMaintenanceModal, #closeMaintenanceModal2"
    );
    const form = document.getElementById("editMaintenanceForm");

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");

            // ✅ ACTION DITAMBAHKAN
            form.action = `/admin/maintenance/update/${id}`;

            document.getElementById("maintenance_edit_id").value = id;
            document.getElementById("maintenance_edit_field_id").value =
                this.getAttribute("data-field");
            document.getElementById("maintenance_edit_date").value =
                this.getAttribute("data-date");
            document.getElementById("maintenance_edit_start_time").value =
                this.getAttribute("data-start");
            document.getElementById("maintenance_edit_end_time").value =
                this.getAttribute("data-end");
            document.getElementById("maintenance_edit_reason").value =
                this.getAttribute("data-reason");

            editModal.classList.remove("hidden");
            setTimeout(() => {
                modalContent.classList.remove("scale-95", "opacity-0");
                modalContent.classList.add("scale-100", "opacity-100");
            }, 10);
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    editModal.addEventListener("click", function (e) {
        if (e.target === editModal) closeModal();
    });

    function closeModal() {
        modalContent.classList.remove("scale-100", "opacity-100");
        modalContent.classList.add("scale-95", "opacity-0");
        setTimeout(() => {
            editModal.classList.add("hidden");
        }, 300);
    }
});
