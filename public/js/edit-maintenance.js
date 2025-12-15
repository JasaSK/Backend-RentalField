document.addEventListener("DOMContentLoaded", function () {
    // Edit Modal Logic
    const editButtons = document.querySelectorAll(".editMaintenanceBtn");
    const editModal = document.getElementById("editMaintenanceModal");
    const modalContent = document.getElementById("modalContent");
    const closeButtons = document.querySelectorAll(
        "#closeMaintenanceModal, #closeMaintenanceModal2"
    );

    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const fieldId = this.getAttribute("data-field");
            const date = this.getAttribute("data-date");
            const startTime = this.getAttribute("data-start");
            const endTime = this.getAttribute("data-end");
            const reason = this.getAttribute("data-reason");

            document.getElementById("maintenance_edit_id").value = id;
            document.getElementById("maintenance_edit_field_id").value =
                fieldId;
            document.getElementById("maintenance_edit_date").value = date;
            document.getElementById("maintenance_edit_start_time").value =
                startTime;
            document.getElementById("maintenance_edit_end_time").value =
                endTime;
            document.getElementById("maintenance_edit_reason").value = reason;

            editModal.classList.remove("hidden");
            setTimeout(() => {
                modalContent.classList.remove("scale-95", "opacity-0");
                modalContent.classList.add("scale-100", "opacity-100");
            }, 10);
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", function () {
            modalContent.classList.remove("scale-100", "opacity-100");
            modalContent.classList.add("scale-95", "opacity-0");
            setTimeout(() => {
                editModal.classList.add("hidden");
            }, 300);
        });
    });

    // Close modal on outside click
    editModal.addEventListener("click", function (e) {
        if (e.target === editModal) {
            modalContent.classList.remove("scale-100", "opacity-100");
            modalContent.classList.add("scale-95", "opacity-0");
            setTimeout(() => {
                editModal.classList.add("hidden");
            }, 300);
        }
    });

    // Form submit handler for edit
    document
        .getElementById("editMaintenanceForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();
            // Add your form submission logic here
            // For now, just close the modal
            modalContent.classList.remove("scale-100", "opacity-100");
            modalContent.classList.add("scale-95", "opacity-0");
            setTimeout(() => {
                editModal.classList.add("hidden");
            }, 300);

            // Show success message
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Maintenance berhasil diperbarui",
                timer: 2000,
                showConfirmButton: false,
            });
        });
});
