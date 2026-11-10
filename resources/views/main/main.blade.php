@extends('layout.main')

@section('content')
  <!-- Hero Section -->
  <section id="home" class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="hero-content">
            <div class="bpbd-badge">
              <i class="fas fa-shield-alt me-2"></i>
              Badan Penanggulangan Bencana Daerah
            </div>
            <h1>Sistem Pemetaan Lokasi Rawan Bencana</h1>
            <p>
              Temukan dan pahami titik-titik rawan bencana dengan visualisasi
              peta yang informatif.
            </p>
            <div class="d-flex gap-3 flex-wrap">
              <a href="#map" class="btn btn-primary btn-lg">
                <i class="fas fa-map-marked-alt me-2"></i>Jelajahi Peta
              </a>
              {{-- <a href="#report" class="btn btn-outline-light btn-lg" data-bs-toggle="modal" data-bs-target="#reportModal">
                <i class="fas fa-plus me-2"></i>Laporkan Bencana
              </a> --}}
            </div>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="alert-emergency h-100">
            <div class="d-flex align-items-center fs-5">
              <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
              <div>
                <h5 class="mb-1">HIMBAUAN KEWASPADAAN</h5>
                <p class="mb-0">
                  Warga diharapkan selalu waspada dan berhati-hati dalam beraktivitas dimanapun kalian berada.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section id="map" class="map-section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Peta Rawan Bencana</h2>
        <p>
          Pantau lokasi dan tingkat kerawanan bencana di wilayah Anda
          teknologi pemetaan digital
        </p>
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="filter-panel" data-aos="fade-right">
            <h5><i class="fas fa-filter"></i> Filter Tingkat Risiko</h5>

            <div class="mb-4">
              <h6 class="fw-semibold mb-3">Pilih Tingkat Kerawanan:</h6>
              <div class="filter-buttons">
                <div class="filter-btn active" data-risk="all">
                  <i class="fas fa-layer-group me-2"></i>Semua
                </div>
                <div class="filter-btn" data-risk="Rendah">
                  <i class="fas fa-check-circle me-2"></i>Rendah
                </div>
                <div class="filter-btn" data-risk="Menengah">
                  <i class="fas fa-exclamation-triangle me-2"></i>Menengah
                </div>
                <div class="filter-btn" data-risk="Tinggi">
                  <i class="fas fa-skull-crossbones me-2"></i>Tinggi
                </div>
              </div>
            </div>

            <!-- Tombol Heatmap -->
            <div class="mb-3">
              <h6 class="fw-semibold mb-2">Heatmap :</h6>
              <button class="btn btn-danger" id="toggleHeatmap" style="width: 100%">
                <i class="fas fa-fire me-2"></i>Heatmap
              </button>
            </div>

            <div class="mb-4" style="display: none">
              <select id="status-filter" class="form-select form-select-sm shadow-sm" disabled>
                <option value="all" selected>Semua Status</option>
              </select>
            </div>

            <h6 class="fw-semibold mb-2">Reset:</h6>
            <button class="btn btn-outline-primary w-100" id="reset-filters">
              <i class="fas fa-refresh me-2"></i>Reset Filter
            </button>
          </div>

          <!-- Quick Stats -->
          <div class="filter-panel" data-aos="fade-right" data-aos-delay="100">
            <h5><i class="fas fa-chart-bar me-2"></i> Statistik Cepat</h5>
            <div class="row text-center">
              <div class="col-6 mb-3">
                <div class="fw-bold text-primary fs-4" id="total-displays">
                  8
                </div>
                <small class="text-muted">Total Titik</small>
              </div>
              <div class="col-6 mb-3">
                <div class="fw-bold text-danger fs-4" id="high-displays">
                  3
                </div>
                <small class="text-muted">Risiko Tinggi</small>
              </div>
              <div class="col-6">
                <div class="fw-bold text-warning fs-4" id="medium-displays">
                  3
                </div>
                <small class="text-muted">Risiko Menengah</small>
              </div>
              <div class="col-6">
                <div class="fw-bold text-success fs-4" id="low-displays">
                  2
                </div>
                <small class="text-muted">Risiko Rendah</small>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <div class="map-container" data-aos="fade-left">
            <div id="disasterMap"></div>
          </div>

          <!-- Legenda Peta Sederhana -->
          <div class="row mt-4">
            <div class="col-12">
              <div class="filter-panel" data-aos="fade-up">
                <div class="row align-items-center">
                  <div class="col-md-4">
                    <h6 class="fw-semibold mb-3">Legenda Tingkat Risiko:</h6>
                    <div class="risk-legend">
                      <div class="risk-color" style="background: var(--risk-low)"></div>
                      <span>Rendah</span>
                    </div>
                    <div class="risk-legend">
                      <div class="risk-color" style="background: var(--risk-medium)"></div>
                      <span>Menengah</span>
                    </div>
                    <div class="risk-legend">
                      <div class="risk-color" style="background: var(--risk-high)"></div>
                      <span>Tinggi</span>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <h6 class="fw-semibold mb-3">Keterangan:</h6>
                    <p class="text-muted mb-0">
                      <small>
                        • <strong>Warna marker</strong> menunjukkan tingkat
                        risiko<br />
                        • <strong>Area lingkaran</strong> menunjukkan
                        perkiraan dampak<br />
                        • Klik marker untuk detail informasi jenis bencana
                      </small>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Analytics Section -->
  <section id="analytics" class="analytics-section">
    <div class="container">
      <div class="section-title" data-aos="fade-up">
        <h2>Analisis Data Bencana</h2>
        <p>
          Data statistik dan analisis tren kejadian bencana
        </p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up">
          <div class="analytics-card">
            <h4 class="mb-4">
              <i class="fas fa-chart-pie me-2"></i> Distribusi Jenis Bencana
            </h4>

            <!-- Banjir -->
            <div class="bencana-item mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                  <div class="bencana-icon me-3" style="color: #17a2b8; background: rgba(23, 162, 184, 0.1);">
                    <i class="fas fa-water"></i>
                  </div>
                  <span class="fw-semibold">Banjir</span>
                </div>
                <span
                  class="fw-bold text-info">{{ number_format(($data->where('jenis_bencana', 'Banjir')->count() / $data->count()) * 100, 1) }}%</span>
              </div>
              <div class="progress mb-2" style="height: 10px">
                <div class="progress-bar"
                  style="width: {{ ($data->where('jenis_bencana', 'Banjir')->count() / $data->count()) * 100 }}%; background: linear-gradient(90deg, #17a2b8, #20c997);">
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <small class="text-white">{{ $data->where('jenis_bencana', 'Banjir')->count() }} Lokasi</small>
              </div>
            </div>

            <!-- Kebakaran Hutan -->
            <div class="bencana-item mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                  <div class="bencana-icon me-3" style="color: #fd7e14; background: rgba(253, 126, 20, 0.1);">
                    <i class="fas fa-fire"></i>
                  </div>
                  <span class="fw-semibold">Kebakaran Hutan</span>
                </div>
                <span
                  class="fw-bold text-warning">{{ number_format(($data->where('jenis_bencana', 'Kebakaran Hutan')->count() / $data->count()) * 100, 1) }}%</span>
              </div>
              <div class="progress mb-2" style="height: 10px">
                <div class="progress-bar"
                  style="width: {{ ($data->where('jenis_bencana', 'Kebakaran Hutan')->count() / $data->count()) * 100 }}%; background: linear-gradient(90deg, #fd7e14, #ffc107);">
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <small class="text-white">{{ $data->where('jenis_bencana', 'Kebakaran Hutan')->count() }}
                  Lokasi</small>
              </div>
            </div>

            <!-- Tanah Longsor -->
            <div class="bencana-item mb-4">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                  <div class="bencana-icon me-3" style="color: #6f42c1; background: rgba(111, 66, 193, 0.1);">
                    <i class="fas fa-mountain"></i>
                  </div>
                  <span class="fw-semibold">Tanah Longsor</span>
                </div>
                <span
                  class="fw-bold text-purple">{{ number_format(($data->where('jenis_bencana', 'Longsor')->count() / $data->count()) * 100, 1) }}%</span>
              </div>
              <div class="progress mb-2" style="height: 10px">
                <div class="progress-bar"
                  style="width: {{ ($data->where('jenis_bencana', 'Longsor')->count() / $data->count()) * 100 }}%; background: linear-gradient(90deg, #6f42c1, #e83e8c);">
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <small class="text-white">{{ $data->where('jenis_bencana', 'Longsor')->count() }} Lokasi</small>
              </div>
            </div>

            <!-- Gunung Api -->
            <div class="bencana-item">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="d-flex align-items-center">
                  <div class="bencana-icon me-3" style="color: #dc3545; background: rgba(220, 53, 69, 0.1);">
                    <i class="fas fa-volcano"></i>
                  </div>
                  <span class="fw-semibold">Gunung Api</span>
                </div>
                <span
                  class="fw-bold text-danger">{{ number_format(($data->where('jenis_bencana', 'Gunung berapi')->count() / $data->count()) * 100, 1) }}%</span>
              </div>
              <div class="progress mb-2" style="height: 10px">
                <div class="progress-bar"
                  style="width: {{ ($data->where('jenis_bencana', 'Gunung berapi')->count() / $data->count()) * 100 }}%; background: linear-gradient(90deg, #dc3545, #fd7e14);">
                </div>
              </div>
              <div class="d-flex justify-content-between">
                <small class="text-whited">{{ $data->where('jenis_bencana', 'Gunung berapi')->count() }}
                  Lokasi</small>
              </div>
            </div>

            <!-- Total Summary -->
            <div class="total-summary mt-4 p-3 rounded" style="background: rgba(255, 255, 255, 0.05);">
              <div class="row text-center">
                <div class="col-6 border-end">
                  <h5 class="fw-bold text-primary mb-1">{{ $data->count() }}</h5>
                  <small class="text-white">Total Kejadian</small>
                </div>
                <div class="col-6">
                  <h5 class="fw-bold text-success mb-1">{{ $data->groupBy('jenis_bencana')->count() }}</h5>
                  <small class="text-white">Jenis Bencana</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('data')
  <script>
    disasters = @json($data);
    //console.log(disasters);
  </script>
@endpush

@push('styles')
  <style>
    .bencana-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.1rem;
    }

    .bencana-item {
      padding: 15px;
      border-radius: 12px;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .bencana-item:hover {
      background: rgba(255, 255, 255, 0.03);
      transform: translateY(-2px);
    }

    .progress {
      background: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    .progress-bar {
      border-radius: 10px;
      transition: width 1s ease-in-out;
    }

    .text-purple {
      color: #6f42c1 !important;
    }

    .total-summary {
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
  </style>
@endpush
