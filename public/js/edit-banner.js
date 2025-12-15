document.addEventListener("DOMContentLoaded", () => {
    const editButtons = document.querySelectorAll(".editBannerBtn");
    const modal = document.getElementById("editBannersModal");
    const cancelEdit = document.querySelectorAll(".btn-cancel-modal");

    const previewImage = document.getElementById("previewBannersImage");
    const editImageInput = document.getElementById("editBannersImage");
    const editName = document.getElementById("editBannersName");
    const editDescription = document.getElementById("editBannersDescription");
    const editStatus = document.getElementById("editBannersStatus");
    const editForm = document.getElementById("editBannersForm");

    // klik tombol edit
    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;

            editForm.action = `/admin/banner/update/${id}`;
            editName.value = btn.dataset.name;
            editDescription.value = btn.dataset.description || "";
            editStatus.value = btn.dataset.status;

            previewImage.src = btn.dataset.image;
            previewImage.classList.remove("hidden");

            modal.classList.remove("hidden");
        });
    });

    // preview gambar baru
    editImageInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                previewImage.src = ev.target.result;
                previewImage.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        }
    });

    // tombol batal (SEMUA)
    cancelEdit.forEach((btn) => {
        btn.addEventListener("click", () => {
            modal.classList.add("hidden");
            editImageInput.value = "";
            previewImage.src = "";
            previewImage.classList.add("hidden");
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("bannerImageInput");
    const preview = document.getElementById("imagePreview");
    const placeholder = document.getElementById("uploadPlaceholder");

    input.addEventListener("change", function () {
        const file = this.files[0];

        if (!file) return;

        if (!file.type.startsWith("image/")) {
            alert("File harus berupa gambar!");
            input.value = "";
            return;
        }

        preview.src = URL.createObjectURL(file);
        preview.classList.remove("hidden");
        placeholder.classList.add("hidden");
    });
});
