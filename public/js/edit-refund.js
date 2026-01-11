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
            const id = this.dataset.id;
            const amount = this.dataset.amount;
            const proof = this.dataset.proof;
            const code = this.dataset.code;
            const reason = this.dataset.reason;

            // Form action
            document.getElementById(
                "editRefundForm"
            ).action = `/admin/refund/accept/${id}`;

            // DISPLAY DATA
            document.getElementById("modalBookingCode").textContent =
                code || "-";
            document.getElementById("modalTotalPrice").textContent =
                "Rp " + Number(amount || 0).toLocaleString("id-ID");

            document.getElementById("modalRefundReason").textContent =
                reason || "Tidak disebutkan";

            // INPUT VALUE
            document.getElementById("refundAmount").value = amount || "";

            // Proof image
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

document.addEventListener("DOMContentLoaded", function () {
    // Search functionality
    const searchInput = document.getElementById("searchRefund");
    const tableBody = document.getElementById("refundTableBody");
    const refundRows = document.querySelectorAll(".refund-row");
    const noResultsMessage = document.getElementById("noResultsMessage");
    const emptyStateRow = document.getElementById("noRefundResult");

    // Sembunyikan empty state awal jika ada data
    if (emptyStateRow && refundRows.length > 0) {
        emptyStateRow.style.display = "none";
    }

    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleRows = 0;

            // Cari di semua baris refund
            refundRows.forEach((row) => {
                const searchData = row.getAttribute("data-refund") || "";
                if (keyword === "" || searchData.includes(keyword)) {
                    row.style.display = "";
                    visibleRows++;
                } else {
                    row.style.display = "none";
                }
            });

            // Tampilkan/sembunyikan pesan tidak ditemukan
            if (noResultsMessage) {
                if (keyword !== "" && visibleRows === 0) {
                    noResultsMessage.classList.remove("hidden");
                    if (emptyStateRow) emptyStateRow.style.display = "none";
                } else {
                    noResultsMessage.classList.add("hidden");
                    if (emptyStateRow && refundRows.length === 0) {
                        emptyStateRow.style.display = "";
                    }
                }
            }
        });
    }
});
