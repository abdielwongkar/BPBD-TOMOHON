// ===== INITIALIZATION =====
document.addEventListener("DOMContentLoaded", function () {
    initializeLoginFunctionality();
    initializeMapFunctionality();
    initializeDashboardFunctionality();
    initializeActiveNavigation();

    // Initialize AOS
    if (typeof AOS !== "undefined") {
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100,
        });
    }
});

function initializeSidebarNavigation() {
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll(".sidebar-menu a");

    // Hapus class active dari semua link
    sidebarLinks.forEach((link) => {
        link.classList.remove("active");
    });

    // Tambah class active ke link yang sesuai dengan halaman saat ini
    sidebarLinks.forEach((link) => {
        const linkPath = link.getAttribute("href");

        // Exact match untuk dashboard
        if (linkPath === currentPath) {
            link.classList.add("active");
        }
        // Partial match untuk halaman lainnya
        else if (
            currentPath.startsWith(linkPath) &&
            linkPath !== "/dashboard"
        ) {
            link.classList.add("active");
        }
    });
}

// ===== LOGIN FUNCTIONALITY =====
function initializeLoginFunctionality() {
    const loginForm = document.getElementById("loginForm");
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");
    const loginButton = document.getElementById("loginButton");

    if (!loginForm || !togglePassword || !passwordInput || !loginButton) {
        return;
    }

    // Toggle Password Visibility
    togglePassword.addEventListener("click", function () {
        const type =
            passwordInput.getAttribute("type") === "password"
                ? "text"
                : "password";
        passwordInput.setAttribute("type", type);

        const icon = this.querySelector("i");
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
    });

    // Form Submission - langsung submit tanpa simulasi
    loginForm.addEventListener("submit", function () {
        // Tampilkan loading state
        loginButton.innerHTML =
            '<div class="spinner-border spinner-border-sm me-2"></div>Memproses...';
        loginButton.disabled = true;
    });

    // Enter key support
    passwordInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            loginForm.requestSubmit(); // Method modern untuk submit form
        }
    });
}
// ===== MAP FUNCTIONALITY =====
function initializeMapFunctionality() {
    const mapElement = document.getElementById("disasterMap");
    if (!mapElement) return;

    // Inisialisasi peta
    map = L.map("disasterMap").setView([1.3202, 124.8394], 12); // pusat kota Tomohon

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap contributors",
    }).addTo(map);

    initMap();

    // Setup heatmap
    const heatPoints = allMarkers.map((marker) => {
        const d = marker.disasterData;
        const intensity =
            d.tingkat_kerentanan === "Tinggi"
                ? 1
                : d.tingkat_kerentanan === "Menengah"
                ? 0.6
                : 0.3;
        return [d.lat, d.lng, intensity];
    });

    const heat = L.heatLayer(heatPoints, {
        radius: 80,
        blur: 35,
        maxZoom: 15,
        gradient: {
            0.3: "blue",
            0.6: "lime",
            0.9: "red",
        },
    }).addTo(map);

    let heatVisible = true;
    const toggleBtn = document.getElementById("toggleHeatmap");

    if (toggleBtn) {
        toggleBtn.addEventListener("click", function () {
            if (heatVisible) {
                map.removeLayer(heat);
                toggleBtn.classList.remove("btn-danger");
                toggleBtn.classList.add("btn-outline-danger");
            } else {
                heat.addTo(map);
                toggleBtn.classList.remove("btn-outline-danger");
                toggleBtn.classList.add("btn-danger");
            }
            heatVisible = !heatVisible;
        });
    }

    // Setup filter functionality
    setupFilterFunctionality();

    // Efek scroll navbar
    window.addEventListener("scroll", function () {
        const nav = document.querySelector(".navbar");
        if (!nav) return;

        if (window.scrollY > 50) {
            nav.style.padding = "10px 0";
            nav.style.boxShadow = "0 5px 20px rgba(0,0,0,0.1)";
        } else {
            nav.style.padding = "15px 0";
            nav.style.boxShadow = "0 2px 10px rgba(0,0,0,0.1)";
        }
    });
}

function getRiskColor(tingkat_kerentanan) {
    switch (tingkat_kerentanan) {
        case "Rendah":
            return "#28a745"; // hijau
        case "Menengah":
            return "#ffc107"; // kuning
        case "Tinggi":
            return "#dc3545"; // merah
        default:
            return "#6c757d"; // abu
    }
}

function initMap() {
    // Tambahkan marker ke peta
    disasters.forEach((disaster) => {
        const iconColor = getRiskColor(disaster.tingkat_kerentanan);

        const icon = L.divIcon({
            className: "custom-icon",
            html: `<div style="background: ${iconColor}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 2px 10px rgba(0,0,0,0.3);"></div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 15],
        });

        const marker = L.marker([disaster.lat, disaster.lng], { icon }).addTo(
            map
        );

        // Tambahkan circle area
        const radius =
            disaster.tingkat_kerentanan === "Rendah"
                ? 500
                : disaster.tingkat_kerentanan === "Menengah"
                ? 800
                : 1200;

        const circle = L.circle([disaster.lat, disaster.lng], {
            color: iconColor,
            fillColor: iconColor,
            fillOpacity: 0.2,
            radius: radius,
        }).addTo(map);

        // Simpan marker & circle
        marker.disasterData = disaster;
        circle.disasterData = disaster;
        allMarkers.push(marker);
        allCircles.push(circle);

        // Popup info
        marker.bindPopup(`
            <div class="p-2">
                <h6 class="fw-bold">${disaster.kelurahan}</h6>
                <p class="mb-1"><strong>Jenis Bencana:</strong> ${
                    disaster.jenis_bencana
                }</p>
                <p class="mb-1"><strong>Tingkat Risiko:</strong> 
                    <span class="badge ${
                        disaster.tingkat_kerentanan === "Rendah"
                            ? "bg-success"
                            : disaster.tingkat_kerentanan === "Menengah"
                            ? "bg-warning"
                            : "bg-danger"
                    }">
                        ${
                            disaster.tingkat_kerentanan === "Rendah"
                                ? "Rendah"
                                : disaster.tingkat_kerentanan === "Menengah"
                                ? "Menengah"
                                : "Tinggi"
                        }
                    </span>
                </p>
            </div>
        `);
    });

    updateStatistics(disasters);
}

// Statistik kecil di dashboard
function updateStatistics(disasters) {
    const total = disasters.length;
    const high = disasters.filter(
        (d) => d.tingkat_kerentanan === "Tinggi"
    ).length;
    const medium = disasters.filter(
        (d) => d.tingkat_kerentanan === "Menengah"
    ).length;
    const low = disasters.filter(
        (d) => d.tingkat_kerentanan === "Rendah"
    ).length;

    const totalDisplay = document.getElementById("total-displays");
    const highDisplay = document.getElementById("high-displays");
    const mediumDisplay = document.getElementById("medium-displays");
    const lowDisplay = document.getElementById("low-displays");

    if (totalDisplay) totalDisplay.textContent = total;
    if (highDisplay) highDisplay.textContent = high;
    if (mediumDisplay) mediumDisplay.textContent = medium;
    if (lowDisplay) lowDisplay.textContent = low;
}

// Filter marker berdasarkan risiko dan status
function filterMarkers(riskLevel, status) {
    allMarkers.forEach((marker) => {
        const d = marker.disasterData;

        // Debug: console.log untuk melihat struktur data
        //console.log("Marker data:", d);

        const showByRisk =
            riskLevel === "all" || d.tingkat_kerentanan === riskLevel;
        const showByStatus = status === "all" || d.jenis_bencana === status; // Menggunakan jenis_bencana sebagai status

        if (showByRisk && showByStatus) {
            if (!map.hasLayer(marker)) {
                marker.addTo(map);
            }
        } else {
            if (map.hasLayer(marker)) {
                map.removeLayer(marker);
            }
        }
    });

    allCircles.forEach((circle) => {
        const d = circle.disasterData;
        const showByRisk =
            riskLevel === "all" || d.tingkat_kerentanan === riskLevel;
        const showByStatus = status === "all" || d.jenis_bencana === status; // Menggunakan jenis_bencana sebagai status

        if (showByRisk && showByStatus) {
            if (!map.hasLayer(circle)) {
                circle.addTo(map);
            }
        } else {
            if (map.hasLayer(circle)) {
                map.removeLayer(circle);
            }
        }
    });

    // Update statistik setelah filter
    const filteredDisasters = disasters.filter((disaster) => {
        const showByRisk =
            riskLevel === "all" || disaster.tingkat_kerentanan === riskLevel;
        const showByStatus =
            status === "all" || disaster.jenis_bencana === status;
        return showByRisk && showByStatus;
    });

    updateStatistics(filteredDisasters);
}

function setupFilterFunctionality() {
    //console.log("Setting up filter functionality...");

    // Filter tombol risiko
    document.querySelectorAll(".filter-btn").forEach((btn) => {
        btn.addEventListener("click", function () {
            //console.log("Risk filter clicked:", this.getAttribute("data-risk"));

            document
                .querySelectorAll(".filter-btn")
                .forEach((b) => b.classList.remove("active"));
            this.classList.add("active");

            const risk = this.getAttribute("data-risk");
            const statusElement = document.getElementById("status-filter");
            const status = statusElement ? statusElement.value : "all";

            //console.log("Filtering with risk:", risk, "status:", status);
            filterMarkers(risk, status);
        });
    });

    // Filter status dropdown
    const statusFilter = document.getElementById("status-filter");
    if (statusFilter) {
        statusFilter.addEventListener("change", function () {
            //console.log("Status filter changed:", this.value);

            const activeBtn = document.querySelector(".filter-btn.active");
            const risk = activeBtn
                ? activeBtn.getAttribute("data-risk")
                : "all";

            //console.log("Filtering with risk:", risk, "status:", this.value);
            filterMarkers(risk, this.value);
        });
    } else {
        console.error("Status filter element not found!");
    }

    // Tombol reset
    const resetBtn = document.getElementById("reset-filters");
    if (resetBtn) {
        resetBtn.addEventListener("click", function () {
            //console.log("Reset filters clicked");

            document
                .querySelectorAll(".filter-btn")
                .forEach((btn) => btn.classList.remove("active"));
            const allBtn = document.querySelector('[data-risk="all"]');
            if (allBtn) allBtn.classList.add("active");

            const statusFilter = document.getElementById("status-filter");
            if (statusFilter) statusFilter.value = "all";

            filterMarkers("all", "all");
        });
    } else {
        console.error("Reset button not found!");
    }

    // Test initial filter
    //console.log("Initial filter setup complete");
    filterMarkers("all", "all");
}

// ===== DASHBOARD FUNCTIONALITY =====
function initializeDashboardFunctionality() {
    // Ripple effect for action buttons
    document.querySelectorAll(".action-btn").forEach((btn) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const ripple = document.createElement("span");
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.cssText = `
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 107, 53, 0.6);
                transform: scale(0);
                animation: ripple 0.6s linear;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                pointer-events: none;
            `;

            this.style.position = "relative";
            this.style.overflow = "hidden";
            this.appendChild(ripple);

            setTimeout(() => {
                if (ripple.parentNode === this) {
                    this.removeChild(ripple);
                }
            }, 600);
        });
    });

    // Smooth hover effects
    document.querySelectorAll(".stat-card, .chart-card").forEach((card) => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-8px)";
        });

        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });
}

// ===== UTILITY FUNCTIONS =====
function showNotification(message, type = "info") {
    // Implement notification system here
    //console.log(`${type.toUpperCase()}: ${message}`);
}

function formatDate(date) {
    return new Date(date).toLocaleDateString("id-ID", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

// ===== ACTIVE NAVIGATION =====
function initializeActiveNavigation() {
    const sections = document.querySelectorAll("section[id]");
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    // Fungsi untuk update active nav
    function updateActiveNav() {
        let currentSection = "";
        const scrollY = window.pageYOffset;
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;

        // Cek jika user sudah scroll sampai paling bawah
        const isAtBottom = scrollY + windowHeight >= documentHeight - 10; // Margin error 10px

        sections.forEach((section) => {
            const sectionHeight = section.offsetHeight;
            const sectionTop = section.offsetTop - 80; // Offset untuk navbar fixed
            const sectionId = section.getAttribute("id");
            const sectionBottom = sectionTop + sectionHeight;

            // Jika di paling bawah, pilih section terakhir
            if (isAtBottom && section === sections[sections.length - 1]) {
                currentSection = sectionId;
            }
            // Normal case: scrollY berada di dalam section
            else if (scrollY >= sectionTop && scrollY < sectionBottom) {
                currentSection = sectionId;
            }
        });

        // Hapus class active dari semua nav link
        navLinks.forEach((link) => {
            link.classList.remove("active");
        });

        // Tambah class active ke nav link yang sesuai
        if (currentSection) {
            const activeLink = document.querySelector(
                `.navbar-nav .nav-link[href="#${currentSection}"]`
            );
            if (activeLink) {
                activeLink.classList.add("active");
            }
        }
    }

    // Event listener untuk scroll (dengan throttle untuk performance)
    let scrollTimer;
    window.addEventListener("scroll", function () {
        clearTimeout(scrollTimer);
        scrollTimer = setTimeout(updateActiveNav, 10);
    });

    window.addEventListener("resize", updateActiveNav);

    // Smooth scroll untuk nav links
    navLinks.forEach((link) => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            const targetId = this.getAttribute("href");
            const targetSection = document.querySelector(targetId);

            if (targetSection) {
                const offsetTop = targetSection.offsetTop - 80; // Offset untuk navbar

                window.scrollTo({
                    top: offsetTop,
                    behavior: "smooth",
                });

                history.pushState(null, null, targetId);
            }
        });
    });

    // Handle URL hash saat page load
    window.addEventListener("load", function () {
        const hash = window.location.hash;
        if (hash) {
            const targetSection = document.querySelector(hash);
            if (targetSection) {
                setTimeout(() => {
                    const offsetTop = targetSection.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: "smooth",
                    });
                }, 100);
            }
        }
        updateActiveNav();
    });

    // Initial call
    updateActiveNav();
}
