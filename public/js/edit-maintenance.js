document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editMaintenanceBtn");
    const modal = document.getElementById("editMaintenanceModal");
    const closeModal = document.getElementById("closeMaintenanceModal");
    const form = document.getElementById("editMaintenanceForm");

    const editStart = document.getElementById("maintenance_edit_start_time");
    const editEnd = document.getElementById("maintenance_edit_end_time");
    const editId = document.getElementById("maintenance_edit_id");

    const editFieldId = document.getElementById("maintenance_edit_field_id")
    const editDate = document.getElementById("maintenance_edit_date")
    const editReason = document.getElementById("maintenance_edit_reason")
    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            // Isi field modal
            editId.value = id;
            editFieldId.value = btn.dataset.field;
            editDate.value = btn.dataset.date;

            editStart.value = btn.dataset.start
                ? btn.dataset.start.slice(0, 5)
                : "";
            editEnd.value = btn.dataset.end
                ? btn.dataset.end.slice(0, 5)
                : "";
            editReason.value = btn.dataset.reason;

            // Set action form
            form.action = `/admin/maintenance/update/${id}`;

            // Tampilkan modal
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        });
    });

    // Tombol batal
    closeModal.addEventListener("click", () => {
        modal.classList.add("hidden");
        modal.classList.remove("flex");
    });

    // Klik area gelap untuk menutup modal
    modal.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
        }
    });
});
