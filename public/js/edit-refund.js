document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("editRefundModal");
    const modalOverlay = document.getElementById("modalOverlay");
    const cancelButtons = document.querySelectorAll(
        "#refundCancel, #modalCancel"
    );
    const editButtons = document.querySelectorAll(".editRefundBtn");
    const imageInput = document.getElementById("refundImageInput");
    const imagePreview = document.getElementById("imagePreview");
    const imagePreviewContainer = document.getElementById(
        "imagePreviewContainer"
    );
    const currentProofContainer = document.getElementById(
        "currentProofContainer"
    );
    const currentProofImage = document.getElementById("currentProofImage");

    // Open modal on edit button click
    editButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const id = this.getAttribute("data-id");
            const amount = this.getAttribute("data-amount");
            const proof = this.getAttribute("data-proof");

            // Set form action
            document.getElementById(
                "editRefundForm"
            ).action = `/admin/refund/accept/${id}`;

            // Set amount
            document.getElementById("refundAmount").value = amount || "";

            // Show current proof if exists
            if (proof) {
                currentProofImage.src = proof;
                currentProofContainer.classList.remove("hidden");
            } else {
                currentProofContainer.classList.add("hidden");
            }

            // Reset preview
            imagePreviewContainer.classList.add("hidden");
            imageInput.value = "";

            // Show modal
            modal.classList.remove("hidden");
            document.body.style.overflow = "hidden";
        });
    });

    // Close modal
    function closeModal() {
        modal.classList.add("hidden");
        document.body.style.overflow = "auto";
    }

    cancelButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    modalOverlay.addEventListener("click", closeModal);

    // Image preview
    imageInput.addEventListener("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        } else {
            imagePreviewContainer.classList.add("hidden");
        }
    });
});

// Image modal functions
function openImageModal(src) {
    document.getElementById("modalImage").src = src;
    document.getElementById("imageModal").classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function closeImageModal() {
    document.getElementById("imageModal").classList.add("hidden");
    document.body.style.overflow = "auto";
}
