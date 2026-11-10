<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    @if (session('success'))
        <meta name="success-message" content="{{ session('success') }}">
    @endif
    @if (session('error'))
        <meta name="error-message" content="{{ session('error') }}">
    @endif

    <title>@yield('title')</title>

    <!-- Favicon -->
    <link rel="icon" href="/assets/img/logo BPBD.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />

    <!-- style css -->
    <link rel="stylesheet" href="/assets/css/style.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')

</head>

<body>
    <div class="dashboard-container">

        <!-- Overlay gelap saat sidebar aktif di mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            {{-- <div class="sidebar-brand">
                <div class="sidebar-logo">
                    <img src="/assets/img/logo BPBD.png" width="50" />
                    BPBD Kota Tomohon
                </div>
                <div class="sidebar-subtitle">
                    Sistem Pemetaan Lokasi Rawan Bencana
                </div>
            </div> --}}
            <div class="sidebar-brand">
                <div class="d-flex align-items-center gap-3">
                    <img src="/assets/img/logo BPBD.png" width="45" height="45" alt="Logo" />
                    <div class="brand-text">
                        <h6 class="sidebar-logo-text mb-0">BPBD Kota Tomohon</h6>
                        <small class="sidebar-subtitle-text">Sistem Pemetaan Bencana</small>
                    </div>
                </div>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ url('/databencana') }}" class="{{ request()->is('databencana*') ? 'active' : '' }}">
                        <i class="fas fa-map"></i> Peta Bencana
                    </a>
                </li>
                {{-- <li>
                    <a href="{{ url('/pengaturan') }}" class="{{ request()->is('pengaturan*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                </li> --}}
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">

                <!-- Tombol Hamburger (hanya tampil di mobile) -->
                <button class="sidebar-toggle-btn" id="sidebarToggle" aria-label="Toggle Sidebar">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="page-title">
                    <h1>@yield('title', 'Dashboard')</h1>
                    <p>Selamat datang kembali, {{ auth()->user()->nama }}</p>
                </div>

                <div class="user-menu" id="userMenu">
                    <div class="d-flex align-items-center">
                        <div class="user-info me-3">
                            <p class="user-name mb-0 fw-semibold">{{ auth()->user()->nama }}</p>
                            <p class="user-role mb-0 text-muted small">{{ auth()->user()->role }}</p>
                        </div>
                        <div class="user-avatar bg-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 45px; height: 45px;">
                            <i class="fas fa-user-shield text-white"></i>
                        </div>
                    </div>

                    <!-- Dropdown Logout -->
                    <div class="logout-dropdown" id="logoutDropdown">
                        <a href="#" class="logout-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>Keluar</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi Logout -->
            <div class="modal fade" id="logoutModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Keluar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin keluar dari sistem?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form method="POST" action="{{ url('/logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">Ya, Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="/assets/js/variabel.js"></script>
    @stack('data')
    <script src="/assets/js/script.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ===== SIDEBAR TOGGLE (MOBILE) =====
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            function openSidebar() {
                sidebar.classList.add('active');
                sidebarOverlay.classList.add('active');
                document.body.style.overflow = 'hidden'; // Cegah scroll background
            }

            function closeSidebar() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Klik tombol hamburger → buka/tutup sidebar
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (sidebar.classList.contains('active')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            // Klik overlay → tutup sidebar
            sidebarOverlay.addEventListener('click', function() {
                closeSidebar();
            });

            // Tekan Escape → tutup sidebar
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSidebar();
                }
            });

            // Tutup sidebar otomatis saat layar diperbesar ke desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });

            // ===== USER MENU DROPDOWN LOGOUT =====
            const userMenu = document.getElementById('userMenu');
            const logoutDropdown = document.getElementById('logoutDropdown');
            const userAvatar = userMenu.querySelector('.user-avatar');

            // Toggle dropdown saat user menu diklik
            userMenu.addEventListener('click', function(e) {
                e.stopPropagation();
                logoutDropdown.classList.toggle('show');
            });

            // Tutup dropdown saat klik di luar area user menu
            document.addEventListener('click', function(e) {
                if (!userMenu.contains(e.target)) {
                    logoutDropdown.classList.remove('show');
                }
            });

            // Tutup dropdown saat modal ditutup
            const logoutModal = document.getElementById('logoutModal');
            if (logoutModal) {
                logoutModal.addEventListener('hidden.bs.modal', function() {
                    logoutDropdown.classList.remove('show');
                });
            }

            // Animasi hover pada avatar
            userAvatar.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });

            userAvatar.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });

        });
    </script>

    <script src="/assets/js/alert.js"></script>
    @stack('scripts')
</body>

</html>
