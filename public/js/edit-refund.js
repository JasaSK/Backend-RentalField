document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("editRefundModal");
    const cancelBtn = document.getElementById("refundCancel");
    const editButtons = document.querySelectorAll(".editRefundBtn");
    const form = document.getElementById("editRefundForm");

    const amount = document.getElementById("refundAmount");
    const preview = document.getElementById("refundPreviewImage");
    const imageInput = document.getElementById("refundImageInput");

    editButtons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const existingImage = btn.dataset.proof;

            form.action = `/admin/refund/accept/${id}`;

            amount.value = btn.dataset.amount || "";

            if (existingImage) {
                preview.src = existingImage;
                preview.classList.remove("hidden");
            } else {
                preview.classList.add("hidden");
            }

            modal.classList.remove("hidden");
        });
    });

    imageInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (ev) => {
            preview.src = ev.target.result;
            preview.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    });

    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
        imageInput.value = "";
        preview.classList.add("hidden");
    });
});
