document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editBtn");
    const modal = document.getElementById("editBannersModal");
    const cancelEdit = document.getElementById("cancelBannersEdit");

    const previewImage = document.getElementById("previewBannersImage");
    const editImageInput = document.getElementById("editBannersImage");
    const editName = document.getElementById("editBannersName");
    const editDescription = document.getElementById("editBannersDescription");
    const editDate = document.getElementById("editBannersDate");
    const editStatus = document.getElementById("editBannersStatus");
    const editForm = document.getElementById("editBannersForm");

    let newImageData = null; // untuk preview sementara

    // klik tombol edit
    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            // update action form sesuai id
            editForm.action = `/admin/banner/update/${id}`;

            // isi form dengan data dari row
            console.log("Edit input element:", editName);
            editName.value = btn.dataset.name;
            console.log("Assigned value:", editName.value);

            editDescription.value = btn.dataset.description;
            editStatus.value = btn.dataset.status;
            editDate.value = btn.dataset.created_at.split("T")[0]; // yyyy-mm-dd

            // tampilkan preview gambar
            previewImage.src = btn.dataset.image;
            previewImage.classList.remove("hidden");

            // tampilkan modal
            modal.classList.remove("hidden");
        });
    });

    // preview gambar baru saat pilih file
    editImageInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                previewImage.src = ev.target.result;
                previewImage.classList.remove("hidden");
                newImageData = ev.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // tutup modal tanpa submit
    cancelEdit.addEventListener("click", () => {
        modal.classList.add("hidden");
        editImageInput.value = "";
        previewImage.src = "";
        previewImage.classList.add("hidden");
    });
});
