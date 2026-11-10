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


    <title>Sistem Pemetaan Bencana BPBD</title>

    <!-- Favicon -->
    <link rel="icon" href="/assets/img/logo BPBD.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

    <!-- style css -->
    <link rel="stylesheet" href="/assets/css/style.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <!-- <i class="fas fa-map-marked-alt me-2"></i>SIG BPBD -->
                <img src="/assets/img/logo BPBD.png" width="50" /> BPBD Kota Tomohon
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#map">Peta Bencana</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#reports">Laporan</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#analytics">Analisis</a>
                    </li>
                    <!-- <li class="nav-item">
              <a class="nav-link" href="#about">Tentang</a>
            </li> -->
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary" href="{{ url('/login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="footer" id="about">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4">
                    <h5>Sistem Pemetaan Lokasi Rawan Bencana</h5>
                    <p class="mt-3">
                        Sistem Badan Penanggulangan Bencana Daerah Kota Tomohon
                        untuk pemetaan dan manajemen bencana berbasis web.
                    </p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        {{-- <a href="#"><i class="fab fa-twitter"></i></a> --}}
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        {{-- <a href="#"><i class="fab fa-youtube"></i></a> --}}
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5>Menu</h5>
                    <ul class="footer-links mt-3">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#map">Peta Bencana</a></li>
                        <li><a href="#analytics">Analisis</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Kontak Darurat</h5>
                    <ul class="footer-links mt-3">
                        <li><i class="fas fa-phone me-2"></i> 112 - Call Center</li>
                        <li><i class="fas fa-phone me-2"></i> 119 - Ambulans</li>
                        <li><i class="fas fa-phone me-2"></i> 113 - Pemadam Kebakaran</li>
                        <li><i class="fas fa-envelope me-2"></i> info@bpbd.go.id</li>
                    </ul>
                </div>

                <div class="col-lg-3">

                    <div class="rounded-lg">
                        <h5>Lokasi Kantor BPBD</h5>
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.772628508651!2d124.81710747363624!3d1.3118144616997165!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32876be921a9d52f%3A0x5f5f4ca15700588c!2sKantor%20Badan%20Penanggulangan%20Bencana%20Daerah%20Kota%20Tomohon!5e0!3m2!1sid!2sus!4v1762845396878!5m2!1sid!2sus"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>

            <div class="copyright">
                <p class="mb-0">
                    &copy; 2026 developed by <a href="#">AJJW</a>.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Custom JS -->
    <script src="/assets/js/variabel.js"></script>
    @stack('data')
    <script src="/assets/js/script.js"></script>
</body>

</html>
