// ==================== NAVBAR HIDE/SHOW ====================
let lastScroll = window.scrollY;
const nav = document.getElementById("sectionNav");

window.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;

    if (currentScroll > lastScroll + 10) {
        // Scroll down -> hide
        nav.classList.add("-translate-y-full");
        nav.classList.remove("translate-y-0");
    } else if (currentScroll < lastScroll - 10) {
        // Scroll up -> show
        nav.classList.remove("-translate-y-full");
        nav.classList.add("translate-y-0");
    }

    lastScroll = currentScroll;
});

// ==================== BANNER CAROUSEL ====================
const carousel = document.getElementById("banner-carousel");
const dots = document.querySelectorAll('[id^="dot-"]');
let index = 0;
let carouselInterval;

function updateCarousel() {
    carousel.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((dot, i) => {
        dot.classList.toggle("bg-black", i === index);
        dot.classList.toggle("bg-gray-400", i !== index);
        dot.classList.toggle("opacity-100", i === index);
        dot.classList.toggle("opacity-60", i !== index);
    });
}

// Mulai carousel otomatis
function startCarousel() {
    carouselInterval = setInterval(() => {
        index = (index + 1) % dots.length;
        updateCarousel();
    }, 4000);
}

// Pause saat hover
carousel.addEventListener("mouseenter", () => clearInterval(carouselInterval));
carousel.addEventListener("mouseleave", startCarousel);

// Inisialisasi
updateCarousel();
startCarousel();

// ==================== GALERI FILTER ====================
const filterButtons = document.querySelectorAll(".filter-btn");
const galleryItems = document.querySelectorAll(".gallery-item");

filterButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
        // Reset semua tombol
        filterButtons.forEach((b) => {
            b.classList.remove("bg-[#13810A]", "text-white");
            b.classList.add("bg-transparent", "text-[#13810A]");
        });

        // Tombol aktif
        btn.classList.remove("bg-transparent", "text-[#13810A]");
        btn.classList.add("bg-[#13810A]", "text-white");

        const filter = btn.dataset.filter;

        // Tampilkan/hilangkan item dengan animasi
        galleryItems.forEach((item) => {
            if (filter === "all" || item.classList.contains(filter)) {
                item.style.display = "block";
                setTimeout(
                    () => item.classList.add("opacity-100", "scale-100"),
                    10
                );
            } else {
                item.classList.remove("opacity-100", "scale-100");
                setTimeout(() => (item.style.display = "none"), 300);
            }
        });
    });
});
