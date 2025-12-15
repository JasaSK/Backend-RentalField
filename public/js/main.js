(function () {
    "use strict";

    // DOM elements
    const loader = document.getElementById("page-loader");
    const loaderText = document.getElementById("loader-text");
    const loadingBar = document.getElementById("loading-bar");
    const body = document.body;

    // Show loading bar animation
    function startLoadingAnimation() {
        if (loadingBar) {
            let progress = 0;
            const animate = () => {
                if (progress < 100) {
                    progress += 1;
                    loadingBar.style.width = progress + "%";

                    if (progress < 80) {
                        setTimeout(animate, 20);
                    } else {
                        setTimeout(animate, 50);
                    }
                }
            };
            setTimeout(animate, 100);
        }
    }

    // Hide loader
    function hideLoader() {
        if (loader) {
            loader.style.opacity = "0";
            setTimeout(() => {
                loader.style.display = "none";
                body.classList.remove("preload");
                body.classList.add("loaded");
            }, 500);
        }
    }

    // Start loading animation immediately
    document.addEventListener("DOMContentLoaded", function () {
        // Start loading bar
        startLoadingAnimation();

        // Setup sidebar
        setupSidebar();
    });

    // When page fully loads
    window.addEventListener("load", function () {
        setTimeout(() => {
            hideLoader();
        }, 800);
    });

    // Setup sidebar - FIXED VERSION
    // Perbaikan di bagian setupSidebar()
    function setupSidebar() {
        const hamburger = document.getElementById("hamburger");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const iconHamburger = document.getElementById("icon-hamburger");
        const iconClose = document.getElementById("icon-close");

        if (!hamburger || !sidebar) return;

        // Debug: Log untuk memastikan elemen ditemukan
        console.log("Hamburger element:", hamburger);
        console.log("Sidebar element:", sidebar);

        // Toggle sidebar function
        function toggleSidebar() {
            console.log("Toggle sidebar clicked");
            const isHidden = sidebar.classList.contains("-translate-x-full");

            if (isHidden) {
                // Show sidebar
                sidebar.classList.remove("-translate-x-full");
                if (overlay) {
                    overlay.classList.remove("hidden");
                    overlay.classList.add("block");
                }
                if (iconHamburger) iconHamburger.classList.add("hidden");
                if (iconClose) iconClose.classList.remove("hidden");
                // Prevent body scroll
                document.body.style.overflow = "hidden";
            } else {
                // Hide sidebar
                sidebar.classList.add("-translate-x-full");
                if (overlay) {
                    overlay.classList.add("hidden");
                    overlay.classList.remove("block");
                }
                if (iconHamburger) iconHamburger.classList.remove("hidden");
                if (iconClose) iconClose.classList.add("hidden");
                // Restore body scroll
                document.body.style.overflow = "auto";
            }
        }

        // Hamburger click event - Gunakan event listener yang lebih reliable
        hamburger.addEventListener(
            "click",
            function (e) {
                console.log("Hamburger clicked");
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                toggleSidebar();
            },
            true
        ); // Gunakan capture phase

        // Overlay click event
        if (overlay) {
            overlay.addEventListener("click", function (e) {
                console.log("Overlay clicked");
                e.stopPropagation();
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
                overlay.classList.remove("block");
                if (iconHamburger) iconHamburger.classList.remove("hidden");
                if (iconClose) iconClose.classList.add("hidden");
                document.body.style.overflow = "auto";
            });
        }

        // Close sidebar on mobile when clicking a link
        const sidebarLinks = document.querySelectorAll("#sidebar nav a");
        sidebarLinks.forEach((link) => {
            link.addEventListener("click", function (e) {
                // Skip if logout form
                if (this.closest(".logout")) return;

                // Only for mobile screens
                if (window.innerWidth < 1024) {
                    setTimeout(() => {
                        sidebar.classList.add("-translate-x-full");
                        if (overlay) {
                            overlay.classList.add("hidden");
                            overlay.classList.remove("block");
                        }
                        if (iconHamburger)
                            iconHamburger.classList.remove("hidden");
                        if (iconClose) iconClose.classList.add("hidden");
                        document.body.style.overflow = "auto";
                    }, 300);
                }
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener("click", function (e) {
            if (
                window.innerWidth < 1024 &&
                !sidebar.contains(e.target) &&
                !hamburger.contains(e.target) &&
                !sidebar.classList.contains("-translate-x-full")
            ) {
                sidebar.classList.add("-translate-x-full");
                if (overlay) {
                    overlay.classList.add("hidden");
                    overlay.classList.remove("block");
                }
                if (iconHamburger) iconHamburger.classList.remove("hidden");
                if (iconClose) iconClose.classList.add("hidden");
                document.body.style.overflow = "auto";
            }
        });

        // Close sidebar with Escape key
        document.addEventListener("keydown", function (e) {
            if (
                e.key === "Escape" &&
                window.innerWidth < 1024 &&
                !sidebar.classList.contains("-translate-x-full")
            ) {
                sidebar.classList.add("-translate-x-full");
                if (overlay) {
                    overlay.classList.add("hidden");
                    overlay.classList.remove("block");
                }
                if (iconHamburger) iconHamburger.classList.remove("hidden");
                if (iconClose) iconClose.classList.add("hidden");
                document.body.style.overflow = "auto";
            }
        });

        // Handle window resize
        window.addEventListener("resize", function () {
            if (window.innerWidth >= 1024) {
                // Pada desktop, pastikan sidebar terlihat dan overlay hidden
                sidebar.classList.remove("-translate-x-full");
                if (overlay) {
                    overlay.classList.add("hidden");
                    overlay.classList.remove("block");
                }
                document.body.style.overflow = "auto";
            } else {
                // Pada mobile, pastikan sidebar tersembunyi
                if (!sidebar.classList.contains("-translate-x-full")) {
                    sidebar.classList.add("-translate-x-full");
                    if (overlay) {
                        overlay.classList.add("hidden");
                        overlay.classList.remove("block");
                    }
                    if (iconHamburger) iconHamburger.classList.remove("hidden");
                    if (iconClose) iconClose.classList.add("hidden");
                }
            }
        });
    }

    // Setup navigation dengan filter untuk tidak pakai loader di beberapa link
    document.addEventListener("click", function (e) {
        const target = e.target.closest("a");

        // SKIP LOADER untuk link tertentu:
        // 1. Link dengan atribut data-no-loader
        // 2. Link logout
        // 3. Link dengan hash (#) anchor
        // 4. External links
        if (
            !target ||
            !target.href ||
            target.hasAttribute("data-no-loader") ||
            target.classList.contains("logout") ||
            target.target === "_blank" ||
            target.hasAttribute("download") ||
            !target.href.startsWith(window.location.origin) ||
            e.ctrlKey ||
            e.metaKey ||
            e.shiftKey ||
            target.href === window.location.href ||
            target.href.includes("#")
        ) {
            return;
        }

        // Get page name for loader text
        let pageName = "Halaman";
        if (target.textContent && target.textContent.trim()) {
            pageName = target.textContent.trim();
        }

        // Update loader text
        if (loaderText) loaderText.textContent = `Memuat ${pageName}`;

        // Show loader for navigation
        if (loader) {
            loader.style.display = "flex";
            loader.style.opacity = "1";
            startLoadingAnimation();
        }
    });

    // Fallback safety
    setTimeout(() => {
        hideLoader();
    }, 3000);
})();
