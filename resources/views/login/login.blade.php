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

  <div class="login-container">
    <div class="login-card">
      <!-- Header -->
      <div class="login-header">
        <div class="logo-container mb-4">
          <!-- <i class="fas fa-map-marked-alt logo-icon"></i> -->
          <img src="/assets/img/logo BPBD.png" width="100" />
        </div>
        <div class="bpbd-badge">
          <i class="fas fa-shield-alt me-2"></i>
          BPBD Kota Tomohon
        </div>
        <p class="login-subtitle">
          Sistem Pemetaan Lokasi Area Rawan Bencana
        </p>
      </div>

      <!-- Warning Alert -->
      <!-- <div class="alert alert-warning" role="alert">
          <i class="fas fa-exclamation-triangle me-2"></i>
          <strong>Perhatian:</strong> Hanya personel terauthorisasi
        </div> -->

      <!-- Login Form -->
      <form id="loginForm" method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="form-group">
          <label for="username" class="form-label">
            <i class="fas fa-user me-2"></i>Username
          </label>
          <div class="input-group">
            <i class="fas fa-user input-icon"></i>
            <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username"
              required />
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="form-label">
            <i class="fas fa-lock me-2"></i>Password
          </label>
          <div class="input-group">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password"
              required />
            <button type="button" class="password-toggle" id="togglePassword">
              <i class="fas fa-eye"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn btn-login text-white" id="loginButton">
          <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Sistem
        </button>
      </form>

      <!-- Footer -->
      <div class="login-footer">
        <a href="{{ url('/') }}" class="back-to-home">
          <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
        </a>
      </div>
    </div>
  </div>

  <!-- Custom JS -->
  <script src="/assets/js/variabel.js"></script>
  <script src="/assets/js/script.js"></script>
  <script src="/assets/js/alert.js"></script>
</body>

</html>
