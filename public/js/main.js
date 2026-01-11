(function () {
    "use strict";

    // DOM elements
    const loader = document.getElementById("page-loader");
    const loaderText = document.getElementById("loader-text");
    const loadingBar = document.getElementById("loading-bar");
    const progressPercentage = document.getElementById("progress-percentage");
    const loadingPhase = document.getElementById("loading-phase");
    const body = document.body;

    // Loading phases with different texts
    const loadingPhases = [
        {
            text: "Initializing system...",
            duration: 200,
        },
        {
            text: "Loading UI components...",
            duration: 300,
        },
        {
            text: "Connecting to database...",
            duration: 400,
        },
        {
            text: "Preparing dashboard...",
            duration: 300,
        },
        {
            text: "Almost ready...",
            duration: 200,
        },
    ];

    // Simulated loading with smooth progress
    function simulateSmoothLoading() {
        let progress = 0;
        let phaseIndex = 0;

        function updateProgress() {
            if (progress < 100) {
                // Calculate increment with easing
                let increment;
                if (progress < 20) {
                    increment = 0.8; // Slow start
                } else if (progress < 80) {
                    increment = 1.5; // Fast middle
                } else {
                    increment = 0.5; // Slow finish
                }

                progress += increment;

                // Update progress bar
                if (loadingBar) {
                    loadingBar.style.width = progress + "%";
                    loadingBar.style.transition = "width 0.1s ease";
                }

                // Update percentage
                if (progressPercentage) {
                    progressPercentage.textContent =
                        Math.min(Math.round(progress), 100) + "%";
                }

                // Update phase text
                if (loadingPhase && phaseIndex < loadingPhases.length) {
                    const phaseProgress = Math.min(progress, 100);
                    const phaseThreshold =
                        (100 / loadingPhases.length) * (phaseIndex + 1);

                    if (phaseProgress >= phaseThreshold) {
                        loadingPhase.textContent =
                            loadingPhases[phaseIndex].text;
                        phaseIndex++;
                    }
                }

                // Continue animation
                setTimeout(updateProgress, 20);
            }
        }

        updateProgress();
    }

    // Hide loader with smooth animation
    function hideLoader() {
        if (loader) {
            // Add fade-out animation
            loader.classList.add("fade-out");

            // Wait for animation to complete
            setTimeout(() => {
                loader.style.display = "none";
                body.classList.remove("preload");
                body.classList.add("loaded");

                // Add fade-in animation to main content
                const mainContent =
                    document.querySelector(".flex.min-h-screen");
                if (mainContent) {
                    mainContent.style.opacity = "1";
                }
            }, 500);
        }
    }

    // Enhanced page transition for navigation
    function setupPageTransitions() {
        document.addEventListener("click", function (e) {
            const target = e.target.closest("a");

            // Skip for special links
            if (
                !target ||
                target.hasAttribute("data-no-loader") ||
                target.classList.contains("logout") ||
                target.target === "_blank" ||
                e.ctrlKey ||
                e.metaKey ||
                !target.href.startsWith(window.location.origin) ||
                target.href.includes("#") ||
                target.href === window.location.href
            ) {
                return;
            }

            // Prevent default to show loader
            e.preventDefault();

            // Get page name
            let pageName = "Halaman";
            if (target.textContent && target.textContent.trim()) {
                pageName = target.textContent.trim();
            }

            // Update loader text
            if (loaderText) {
                loaderText.innerHTML = `Memuat ${pageName} <div class="loading-dots inline-flex ml-2"><span></span><span></span><span></span></div>`;
            }

            // Show loader with animation
            if (loader) {
                loader.style.display = "flex";
                loader.style.opacity = "1";
                loader.classList.remove("fade-out");

                // Reset and start progress
                if (loadingBar) {
                    loadingBar.style.width = "0%";
                }
                if (progressPercentage) {
                    progressPercentage.textContent = "0%";
                }
                if (loadingPhase) {
                    loadingPhase.textContent = "Memulai...";
                }

                simulateSmoothLoading();

                // Navigate after showing loader
                setTimeout(() => {
                    window.location.href = target.href;
                }, 800);
            } else {
                // Fallback to normal navigation
                window.location.href = target.href;
            }
        });
    }

    // Initialize everything when DOM is ready
    document.addEventListener("DOMContentLoaded", function () {
        // Start smooth loading animation
        simulateSmoothLoading();

        // Setup page transitions
        setupPageTransitions();

        // Setup sidebar (your existing function)
        setupSidebar();
    });

    // When page fully loads
    window.addEventListener("load", function () {
        // Complete progress to 100%
        if (loadingBar) {
            loadingBar.style.width = "100%";
            loadingBar.style.transition = "width 0.3s ease";
        }
        if (progressPercentage) {
            progressPercentage.textContent = "100%";
        }
        if (loadingPhase) {
            loadingPhase.textContent = "Dashboard siap!";
        }

        // Hide loader after a brief delay
        setTimeout(hideLoader, 500);
    });

    // Fallback: Hide loader after max timeout
    setTimeout(() => {
        if (body.classList.contains("preload")) {
            hideLoader();
        }
    }, 4000);

    // Your existing setupSidebar function
    function setupSidebar() {
        const hamburger = document.getElementById("hamburger");
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const iconHamburger = document.getElementById("icon-hamburger");
        const iconClose = document.getElementById("icon-close");

        if (!hamburger || !sidebar) return;

        function toggleSidebar() {
            const isHidden = sidebar.classList.contains("-translate-x-full");

            if (isHidden) {
                sidebar.classList.remove("-translate-x-full");
                if (overlay) {
                    overlay.classList.remove("hidden");
                    overlay.classList.add("block");
                }
                if (iconHamburger) iconHamburger.classList.add("hidden");
                if (iconClose) iconClose.classList.remove("hidden");
                document.body.style.overflow = "hidden";
            } else {
                sidebar.classList.add("-translate-x-full");
                if (overlay) {
                    overlay.classList.add("hidden");
                    overlay.classList.remove("block");
                }
                if (iconHamburger) iconHamburger.classList.remove("hidden");
                if (iconClose) iconClose.classList.add("hidden");
                document.body.style.overflow = "auto";
            }
        }

        hamburger.addEventListener(
            "click",
            function (e) {
                e.preventDefault();
                toggleSidebar();
            },
            true
        );

        if (overlay) {
            overlay.addEventListener("click", function (e) {
                e.stopPropagation();
                sidebar.classList.add("-translate-x-full");
                overlay.classList.add("hidden");
                overlay.classList.remove("block");
                if (iconHamburger) iconHamburger.classList.remove("hidden");
                if (iconClose) iconClose.classList.add("hidden");
                document.body.style.overflow = "auto";
            });
        }

        const sidebarLinks = document.querySelectorAll("#sidebar nav a");
        sidebarLinks.forEach((link) => {
            link.addEventListener("click", function (e) {
                if (this.closest(".logout")) return;
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

        window.addEventListener("resize", function () {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove("-translate-x-full");
                if (overlay) {
                    overlay.classList.add("hidden");
                    overlay.classList.remove("block");
                }
                document.body.style.overflow = "auto";
            } else {
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
})();


