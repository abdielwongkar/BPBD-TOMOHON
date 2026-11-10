@extends('layout.dashboard')

@section('title')
    Peta Bencana
@endsection

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Stats Grid dengan Bootstrap -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card p-4" style="border-left-color: var(--accent-orange)">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-4" style="background: var(--gradient-primary)">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $data->count() }}</h3>
                        <p>Total Rawan Bencana</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card p-4" style="border-left-color: var(--danger-color)">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-4" style="background: var(--gradient-danger)">
                        <i class="fas fa-skull-crossbones"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $data->where('tingkat_kerentanan', 'Tinggi')->count() }}</h3>
                        <p>Tingkat Tinggi</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card p-4" style="border-left-color: var(--warning-color)">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-4" style="background: var(--gradient-warning)">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $data->where('tingkat_kerentanan', 'Menengah')->count() }}</h3>
                        <p>Tingkat Menengah</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="stat-card p-4" style="border-left-color: var(--success-color)">
                <div class="d-flex align-items-center">
                    <div class="stat-icon me-4" style="background: var(--gradient-success)">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3>{{ $data->where('tingkat_kerentanan', 'Rendah')->count() }}</h3>
                        <p>Tingkat Rendah</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <section id="map-section">
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
                </div>
            </div>

            <div class="col-lg-9">
                <div class="map-container" data-aos="fade-left">
                    <div id="disasterMap"></div>
                </div>
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
    </section>

    <!-- Datatables -->
    <div class="row mt-1">
        <div class="col-12">
            <div class="filter-panel p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Daftar Data</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahDataModal">Tambah
                        Data</button>
                </div>

                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan</th>
                                <th>Jenis Bencana</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Tingkat Kerentanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kecamatan }}</td>
                                    <td>{{ $item->kelurahan }}</td>
                                    <td>{{ $item->jenis_bencana }}</td>
                                    <td>{{ $item->lat }}</td>
                                    <td>{{ $item->lng }}</td>
                                    <td>
                                        @if ($item->tingkat_kerentanan == 'Tinggi')
                                            <span
                                                class="badge bg-danger bg-gradient px-2 py-1 fw-bold border border-2 border-white shadow-sm">
                                                <i class="fas fa-fire me-1 small"></i>Tinggi
                                            </span>
                                        @elseif($item->tingkat_kerentanan == 'Menengah')
                                            <span
                                                class="badge bg-warning bg-gradient px-2 py-1 fw-bold text-dark border border-2 border-white shadow-sm">
                                                <i class="fas fa-exclamation-triangle me-1 small"></i>Menengah
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-success bg-gradient px-2 py-1 fw-bold border border-2 border-white shadow-sm">
                                                <i class="fas fa-check-circle me-1 small"></i>Rendah
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm text-white px-3"
                                            style="background: linear-gradient(135deg, #17a2b8, #138496); border: none;"
                                            data-bs-toggle="modal" data-bs-target="#detailModal"
                                            data-curah="{{ $item->curah_hujan }}"
                                            data-kemiringan="{{ $item->kemiringan_lereng }}"
                                            data-vegetasi="{{ $item->vegetasi }}"
                                            data-riwayat="{{ $item->riwayat_bencana }}"
                                            data-jarak="{{ $item->jarak_sumber_bahaya }}" data-id="{{ $item->id }}">
                                            <i class="fas fa-clipboard-list me-1"></i>Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-plus-circle me-2 fs-5"></i>
                        <h5 class="modal-title mb-0" id="modalTambahLabel">Tambah Data Bencana Baru</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="formTambahData" action="{{ route('bencana.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kecamatan" class="form-label">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>Kecamatan
                                </label>
                                <select class="form-select" id="kecamatan" name="kecamatan" required>
                                    <option value="Tomohon Utara">Tomohon Utara</option>
                                    <option value="Tomohon Tengah">Tomohon Tengah</option>
                                    <option value="Tomohon Barat">Tomohon Barat</option>
                                    <option value="Tomohon Timur">Tomohon Timur</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kelurahan" class="form-label">
                                    <i class="fas fa-location-dot text-success me-2"></i>Kelurahan
                                </label>
                                <input type="text" class="form-control" id="kelurahan" name="kelurahan"
                                    placeholder="Masukkan nama kelurahan" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jenis_bencana" class="form-label">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>Jenis Bencana
                                </label>
                                <select class="form-select" id="jenis_bencana" name="jenis_bencana" required>
                                    <option value="Longsor">Longsor</option>
                                    <option value="Banjir">Banjir</option>
                                    <option value="Kebakaran Hutan">Kebakaran Hutan</option>
                                    <option value="Gunung berapi">Gunung berapi</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kriteria Fuzzy Logic yang User-Friendly -->
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-sliders-h me-2"></i>Kondisi Lokasi
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="curah_hujan" class="form-label">
                                            <i class="fas fa-cloud-rain me-2 text-info"></i>Intensitas Curah Hujan
                                        </label>
                                        <select class="form-select" id="curah_hujan" name="curah_hujan" required>
                                            <option value="0.2">Sangat Rendah (Jarang Hujan)</option>
                                            <option value="0.4">Rendah (Hujan Sesekali)</option>
                                            <option value="0.6">Sedang (Cukup Sering Hujan)</option>
                                            <option value="0.8">Tinggi (Sering Hujan Lebat)</option>
                                            <option value="1.0">Sangat Tinggi (Hujan Sangat Sering & Lebat)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kemiringan_lereng" class="form-label">
                                            <i class="fas fa-mountain me-2 text-warning"></i>Kemiringan Lereng
                                        </label>
                                        <select class="form-select" id="kemiringan_lereng" name="kemiringan_lereng"
                                            required>
                                            <option value="0.2">Datar (0-15%)</option>
                                            <option value="0.4">Landai (15-30%)</option>
                                            <option value="0.6">Agak Curam (30-45%)</option>
                                            <option value="0.8">Curam (45-60%)</option>
                                            <option value="1.0">Sangat Curam (>60%)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="vegetasi" class="form-label">
                                            <i class="fas fa-tree me-2 text-success"></i>Kepadatan Vegetasi
                                        </label>
                                        <select class="form-select" id="vegetasi" name="vegetasi" required>
                                            <option value="1.0">Sangat Jarang (Hampir Tidak Ada)</option>
                                            <option value="0.8">Jarang (Sedikit Vegetasi)</option>
                                            <option value="0.6">Sedang (Cukup Banyak)</option>
                                            <option value="0.4">Rapat (Banyak Vegetasi)</option>
                                            <option value="0.2">Sangat Rapat (Sangat Banyak Vegetasi)</option>
                                        </select>
                                        <div class="form-text">Semakin rapat vegetasi, semakin rendah risiko</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="riwayat_bencana" class="form-label">
                                            <i class="fas fa-history me-2 text-secondary"></i>Riwayat Kejadian Bencana
                                        </label>
                                        <select class="form-select" id="riwayat_bencana" name="riwayat_bencana" required>
                                            <option value="0.2">Tidak Pernah</option>
                                            <option value="0.4">Jarang (1-2 kali dalam 10 tahun)</option>
                                            <option value="0.6">Kadang-kadang (3-5 kali dalam 10 tahun)</option>
                                            <option value="0.8">Sering (1-2 kali per tahun)</option>
                                            <option value="1.0">Sangat Sering (>3 kali per tahun)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Opsional: Jarak Sumber Bahaya -->
                                <div class="row" id="jarakSumberContainer" style="display: none;">
                                    <div class="col-md-12 mb-3">
                                        <label for="jarak_sumber_bahaya" class="form-label">
                                            <i class="fas fa-ruler me-2 text-danger"></i>Jarak dari Sumber Bahaya
                                        </label>
                                        <select class="form-select" id="jarak_sumber_bahaya" name="jarak_sumber_bahaya">
                                            <option value="0.2">Sangat Jauh (>2 km)</option>
                                            <option value="0.4">Jauh (1-2 km)</option>
                                            <option value="0.6">Sedang (500 m - 1 km)</option>
                                            <option value="0.8">Dekat (100-500 m)</option>
                                            <option value="1.0">Sangat Dekat (<100 m)</option>
                                        </select>
                                        <div class="form-text" id="jarakSumberText"></div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- Map untuk Input Koordinat -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-map-marked-alt me-2"></i>Pilih Koordinat di Peta
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="lat" class="form-label">Latitude</label>
                                        <input type="number" step="any" class="form-control" id="lat"
                                            name="lat" placeholder="Contoh: 1.325630" required readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lng" class="form-label">Longitude</label>
                                        <input type="number" step="any" class="form-control" id="lng"
                                            name="lng" placeholder="Contoh: 124.818924" required readonly>
                                    </div>
                                </div>
                                <div id="modalMap" style="height: 400px; border-radius: 8px;"></div>
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle text-info me-1"></i>
                                    Klik pada peta untuk memilih koordinat lokasi bencana
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary" form="formTambahData" id="btnSubmit">
                        <i class="fas fa-save me-1"></i>Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2"></i>
                        <h5 class="modal-title mb-0 fw-bold" id="detailModalLabel">Detail Lokasi Bencana</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Informasi Umum -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold text-primary">
                                <i class="fas fa-map-marker-alt me-2"></i>Informasi Lokasi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold text-muted" width="40%">Kecamatan</td>
                                            <td id="detailKecamatan">-</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Kelurahan</td>
                                            <td id="detailKelurahan">-</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Jenis Bencana</td>
                                            <td id="detailJenisBencana">-</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td class="fw-bold text-muted" width="40%">Koordinat</td>
                                            <td id="detailKoordinat">-</td>
                                        </tr>
                                        <tr>
                                            <td class="fw-bold text-muted">Tingkat Kerentanan</td>
                                            <td id="detailTingkatKerentanan">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Parameter Analisis Fuzzy Logic -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold text-success">
                                <i class="fas fa-chart-bar me-2"></i>Parameter Analisis
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Curah Hujan -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <i class="fas fa-cloud-rain fa-xl text-info mb-2"></i>
                                        <h6 class="mb-1 small fw-bold">Curah Hujan</h6>
                                        <span class="badge fs-6 fw-bold" id="detailCurah">-</span>
                                        <div class="mt-1">
                                            <small class="text-muted" id="detailCurahValue">-</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Kemiringan Lereng -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <i class="fas fa-mountain fa-xl text-warning mb-2"></i>
                                        <h6 class="mb-1 small fw-bold">Kemiringan Lereng</h6>
                                        <span class="badge fs-6 fw-bold" id="detailKemiringan">-</span>
                                        <div class="mt-1">
                                            <small class="text-muted" id="detailKemiringanValue">-</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vegetasi -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <i class="fas fa-tree fa-xl text-success mb-2"></i>
                                        <h6 class="mb-1 small fw-bold">Vegetasi</h6>
                                        <span class="badge fs-6 fw-bold" id="detailVegetasi">-</span>
                                        <div class="mt-1">
                                            <small class="text-muted" id="detailVegetasiValue">-</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Riwayat Bencana -->
                                <div class="col-md-3 col-6">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <i class="fas fa-history fa-xl text-danger mb-2"></i>
                                        <h6 class="mb-1 small fw-bold">Riwayat Bencana</h6>
                                        <span class="badge fs-6 fw-bold" id="detailRiwayat">-</span>
                                        <div class="mt-1">
                                            <small class="text-muted" id="detailRiwayatValue">-</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Jarak Sumber Bahaya (jika ada) -->
                            <div class="row mt-3" id="jarakSumberRow" style="display: none;">
                                <div class="col-12">
                                    <div class="text-center p-3 border rounded bg-light">
                                        <i class="fas fa-ruler fa-xl text-secondary mb-2"></i>
                                        <h6 class="mb-1 small fw-bold">Jarak Sumber Bahaya</h6>
                                        <span class="badge fs-6 fw-bold" id="detailJarak">-</span>
                                        <div class="mt-1">
                                            <small class="text-muted" id="detailJarakValue">-</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keterangan Fuzzy Logic -->
                    <div class="card border-0 shadow-sm mt-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold text-info">
                                <i class="fas fa-brain me-2"></i>Keterangan
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-muted mb-2">Kategori Nilai:</h6>
                                    <ul class="list-unstyled small">
                                        <li><span class="badge bg-success">Rendah</span> : 0.00 - 0.30</li>
                                        <li><span class="badge bg-warning text-dark">Menengah</span> : 0.31 - 0.60</li>
                                        <li><span class="badge bg-danger">Tinggi</span> : 0.61 - 1.00</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-muted mb-2">Keterangan:</h6>
                                    <ul class="list-unstyled small">
                                        <li>• Vegetasi: Semakin tinggi nilai = semakin aman</li>
                                        <li>• Jarak: Semakin tinggi nilai = semakin dekat bahaya</li>
                                        <li>• Analisis menggunakan Fuzzy Logic</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                responsive: true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
                }
            });

            // Saat modal detail akan ditampilkan
            $('#detailModal').on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // tombol yang diklik
                const item = button.closest('tr'); // row data

                // Ambil data dari tabel
                const kecamatan = item.find('td:eq(1)').text();
                const kelurahan = item.find('td:eq(2)').text();
                const jenisBencana = item.find('td:eq(3)').text();
                const lat = item.find('td:eq(4)').text();
                const lng = item.find('td:eq(5)').text();
                const tingkatKerentanan = item.find('td:eq(6)').text();

                // Ambil data dari attributes (jika ada)
                const curah = button.data('curah');
                const kemiringan = button.data('kemiringan');
                const vegetasi = button.data('vegetasi');
                const riwayat = button.data('riwayat');
                const jarak = button.data('jarak');

                // Fungsi untuk mengkonversi nilai menjadi kategori dengan styling
                function konversiKategori(nilai) {
                    if (nilai <= 0.3) {
                        return '<span class="badge bg-success">Rendah</span>';
                    } else if (nilai <= 0.6) {
                        return '<span class="badge bg-warning text-dark">Menengah</span>';
                    } else if (nilai <= 1.0) {
                        return '<span class="badge bg-danger">Tinggi</span>';
                    } else {
                        return '<span class="badge bg-secondary">Tidak Valid</span>';
                    }
                }

                // Fungsi untuk format nilai
                function formatNilai(nilai) {
                    return parseFloat(nilai).toFixed(2);
                }

                // Isi data informasi umum
                $('#detailKecamatan').text(kecamatan);
                $('#detailKelurahan').text(kelurahan);
                $('#detailJenisBencana').text(jenisBencana);
                $('#detailKoordinat').text(lat + ', ' + lng);
                $('#detailTingkatKerentanan').html(tingkatKerentanan);

                // Isi data parameter analisis
                if (curah) {
                    $('#detailCurah').html(konversiKategori(curah));
                    $('#detailCurahValue').text(formatNilai(curah));
                }
                if (kemiringan) {
                    $('#detailKemiringan').html(konversiKategori(kemiringan));
                    $('#detailKemiringanValue').text(formatNilai(kemiringan));
                }
                if (vegetasi) {
                    $('#detailVegetasi').html(konversiKategori(vegetasi));
                    $('#detailVegetasiValue').text(formatNilai(vegetasi));
                }
                if (riwayat) {
                    $('#detailRiwayat').html(konversiKategori(riwayat));
                    $('#detailRiwayatValue').text(formatNilai(riwayat));
                }

                // Handle jarak sumber bahaya (jika ada)
                if (jarak) {
                    $('#jarakSumberRow').show();
                    $('#detailJarak').html(konversiKategori(jarak));
                    $('#detailJarakValue').text(formatNilai(jarak));
                    $('#detailJarakSumber').text(formatNilai(jarak));
                } else {
                    $('#jarakSumberRow').hide();
                    $('#detailJarakSumber').text('Tidak tersedia');
                }

                // Set ID data untuk edit (jika diperlukan)
                const dataId = button.data('id');
                $('#btnEditData').attr('data-id', dataId);
            });

            // Reset modal ketika ditutup
            $('#detailModal').on('hidden.bs.modal', function() {
                // Reset semua field
                $('#detailKecamatan').text('-');
                $('#detailKelurahan').text('-');
                $('#detailJenisBencana').text('-');
                $('#detailKoordinat').text('-');
                $('#detailTingkatKerentanan').text('-');
                $('#detailJarakSumber').text('-');

                // Reset parameter analisis
                $('#detailCurah').html('-');
                $('#detailCurahValue').text('-');
                $('#detailKemiringan').html('-');
                $('#detailKemiringanValue').text('-');
                $('#detailVegetasi').html('-');
                $('#detailVegetasiValue').text('-');
                $('#detailRiwayat').html('-');
                $('#detailRiwayatValue').text('-');
                $('#detailJarak').html('-');
                $('#detailJarakValue').text('-');
            });

            // Fungsi untuk mengatur tampilan field jarak sumber bahaya
            function setupJarakSumberBahaya() {
                const jenisBencanaSelect = document.getElementById('jenis_bencana');
                const jarakContainer = document.getElementById('jarakSumberContainer');
                const jarakText = document.getElementById('jarakSumberText');

                if (jenisBencanaSelect && jarakContainer && jarakText) {
                    jenisBencanaSelect.addEventListener('change', function() {
                        const jenisBencana = this.value;

                        if (jenisBencana === 'Gunung berapi' || jenisBencana === 'Banjir') {
                            jarakContainer.style.display = 'block';
                            if (jenisBencana === 'Gunung berapi') {
                                jarakText.textContent = 'Jarak dari kawah/kaldera gunung berapi';
                            } else if (jenisBencana === 'Banjir') {
                                jarakText.textContent = 'Jarak dari sungai/sumber banjir';
                            }
                            document.getElementById('jarak_sumber_bahaya').required = true;
                        } else {
                            jarakContainer.style.display = 'none';
                            document.getElementById('jarak_sumber_bahaya').required = false;
                        }
                    });
                }
            }

            // Inisialisasi ketika modal tambah data dibuka
            $('#tambahDataModal').on('shown.bs.modal', function() {
                setupJarakSumberBahaya();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi peta modal dengan ID yang berbeda
            const modalMap = L.map('modalMap').setView([1.325630, 124.818924], 13);

            // Tambahkan tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(modalMap);

            // Variabel untuk marker
            let modalMarker = null;

            // Event click pada peta modal
            modalMap.on('click', function(e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Update input fields
                document.getElementById('lat').value = lat.toFixed(6);
                document.getElementById('lng').value = lng.toFixed(6);

                // Hapus marker lama jika ada
                if (modalMarker) {
                    modalMap.removeLayer(modalMarker);
                }

                // Tambahkan marker baru
                modalMarker = L.marker([lat, lng])
                    .addTo(modalMap)
                    .bindPopup('Lokasi yang dipilih: ' + lat.toFixed(6) + ', ' + lng.toFixed(6))
                    .openPopup();
            });

            // Event ketika modal dibuka
            $('#tambahDataModal').on('shown.bs.modal', function() {
                setTimeout(function() {
                    modalMap.invalidateSize();
                    modalMap.setView([1.325630, 124.818924], 13);
                }, 100);
            });

            // Event ketika modal ditutup
            $('#tambahDataModal').on('hidden.bs.modal', function() {
                // Reset form dan hapus marker
                if (modalMarker) {
                    modalMap.removeLayer(modalMarker);
                    modalMarker = null;
                }
                document.getElementById('lat').value = '';
                document.getElementById('lng').value = '';
            });

            // Validasi form sebelum submit
            document.getElementById('formTambahData').addEventListener('submit', function(e) {
                e.preventDefault();

                // Validasi koordinat
                const lat = document.getElementById('lat').value;
                const lng = document.getElementById('lng').value;

                if (!lat || !lng) {
                    alert('Silakan pilih koordinat lokasi pada peta!');
                    return;
                }

                // Jika semua valid, submit form
                this.submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // SweetAlert untuk proses analisis
            @if (session('analyzing'))
                Swal.fire({
                    title: 'Menganalisis Tingkat Kerentanan',
                    html: 'Sedang memproses data dan menghitung tingkat kerentanan...',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                    },
                    willClose: () => {
                        // Setelah analisis selesai, tampilkan hasil sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: '{{ session('success') }}',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            @endif

            // SweetAlert untuk error
            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            @endif

            // Saat form disubmit, tampilkan loading
            document.getElementById('formTambahData').addEventListener('submit', function(e) {
                // Validasi koordinat
                const lat = document.getElementById('lat').value;
                const lng = document.getElementById('lng').value;

                if (!lat || !lng) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Silakan pilih koordinat lokasi pada peta!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Nonaktifkan tombol dan tampilkan loading
                document.getElementById('btnSubmit').disabled = true;
                document.getElementById('btnSubmit').innerHTML =
                    '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            });

        });
    </script>
    <script>
        // Nonaktifkan tombol saat proses submit
        document.getElementById('formTambahData').addEventListener('submit', function() {
            document.getElementById('btnSubmit').disabled = true;
            document.getElementById('btnSubmit').innerHTML =
                '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        });
    </script>
@endpush

@push('data')
    <script>
        disasters = @json($data);
        //console.log(disasters);
    </script>
@endpush
