@extends('layout.dashboard')

@section('title')
    Dashboard
@endsection


@section('styles')
    <!-- Tambahan CSS untuk tombol toggle -->
@endsection

@section('content')
    {{-- <!-- Alert Banner -->
    <div class="alert-banner">
        <i class="fas fa-exclamation-triangle alert-icon"></i>
        <div class="alert-content">
            <h4 class="alert-title">HIMBAUAN KEWASPADAAN</h4>
            <p class="alert-desc">
                Diharapkan selalu waspada dan berhati-hati dalam beraktivitas dimanapun kalian berada.
            </p>
        </div>
    </div> --}}

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

    <!-- Charts Grid dengan Bootstrap -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Distribusi Tingkat Kerentanan Bencana</h3>
                    <div class="chart-actions">
                        <button class="btn-icon" id="toggleDetailBtn" title="Toggle Detail">
                            <i class="fas fa-chart-pie"></i> <span id="toggleText">Tampilkan Detail</span>
                        </button>
                        <a href="#" class="btn-icon" id="downloadChartBtn" title="Download"><i
                                class="fas fa-download"></i></a>
                        <a href="#" class="btn-icon" id="fullscreenChartBtn" title="Fullscreen"><i
                                class="fas fa-expand"></i></a>
                    </div>
                </div>
                <div class="chart-placeholder">
                    <canvas id="disasterPieChart" style="max-height: 350px; width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data tingkat kerentanan (untuk tampilan awal)
            const tingkatData = {
                labels: ['Tingkat Tinggi', 'Tingkat Menengah', 'Tingkat Rendah'],
                values: [
                    {{ $data->where('tingkat_kerentanan', 'Tinggi')->count() }},
                    {{ $data->where('tingkat_kerentanan', 'Menengah')->count() }},
                    {{ $data->where('tingkat_kerentanan', 'Rendah')->count() }}
                ]
            };

            // Data detail berdasarkan jenis bencana per tingkat kerentanan
            const detailData = {
                tinggi: @json(
                    $data->where('tingkat_kerentanan', 'Tinggi')->groupBy('jenis_bencana')->map(function ($item) {
                            return $item->count();
                        })),
                menengah: @json(
                    $data->where('tingkat_kerentanan', 'Menengah')->groupBy('jenis_bencana')->map(function ($item) {
                            return $item->count();
                        })),
                rendah: @json(
                    $data->where('tingkat_kerentanan', 'Rendah')->groupBy('jenis_bencana')->map(function ($item) {
                            return $item->count();
                        }))
            };

            // Warna cerah untuk tingkat kerentanan
            const tingkatColors = [
                '#FF3366', // Merah cerah untuk Tinggi
                '#FF9933', // Oranye cerah untuk Menengah
                '#33CC99' // Hijau toska cerah untuk Rendah
            ];

            // Palet warna cerah untuk jenis bencana (lebih dari 15 warna)
            const brightColorPalette = [
                '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
                '#DDA0DD', '#98D8C8', '#F7B05E', '#B5EAD7', '#FFD93D',
                '#C7B9FF', '#FF9AA2', '#B5F2E8', '#FFB7B2', '#E2F0CB',
                '#FFDAC1', '#A9E5BB', '#FFC8A2', '#C5E0D4', '#FFB5A7'
            ];

            const ctx = document.getElementById('disasterPieChart').getContext('2d');
            let isDetailMode = false;
            let currentChart = null;

            // Fungsi untuk mendapatkan data detail yang digabung
            function getCombinedDetailData() {
                let combinedLabels = [];
                let combinedValues = [];
                let combinedColors = [];
                let colorIndex = 0;

                // Fungsi helper untuk menambah data dengan prefix tingkat kerentanan
                function addDetailData(level, levelName, dataObj) {
                    const entries = Object.entries(dataObj);
                    if (entries.length > 0) {
                        entries.forEach(([jenis, count]) => {
                            combinedLabels.push(`${levelName}: ${jenis}`);
                            combinedValues.push(count);
                            combinedColors.push(brightColorPalette[colorIndex % brightColorPalette.length]);
                            colorIndex++;
                        });
                    }
                }

                // Tambah data dari setiap tingkat kerentanan
                addDetailData('tinggi', '🔴 Tinggi', detailData.tinggi);
                addDetailData('menengah', '🟠 Menengah', detailData.menengah);
                addDetailData('rendah', '🟢 Rendah', detailData.rendah);

                return {
                    labels: combinedLabels,
                    values: combinedValues,
                    colors: combinedColors
                };
            }

            // Fungsi untuk membuat/update chart
            function renderChart() {
                let data, options;

                if (isDetailMode) {
                    // Mode detail: menampilkan jenis bencana dengan prefix tingkat kerentanan
                    const detail = getCombinedDetailData();
                    data = {
                        labels: detail.labels,
                        datasets: [{
                            data: detail.values,
                            backgroundColor: detail.colors,
                            borderColor: '#ffffff',
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    };
                    options = {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    font: {
                                        size: 11
                                    },
                                    usePointStyle: true,
                                    boxWidth: 10,
                                    padding: 10
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} kejadian (${percentage}%)`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: 'Detail Jenis Bencana per Tingkat Kerentanan',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                padding: {
                                    bottom: 15
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 800
                        }
                    };
                } else {
                    // Mode ringkasan: menampilkan tingkat kerentanan
                    data = {
                        labels: tingkatData.labels,
                        datasets: [{
                            data: tingkatData.values,
                            backgroundColor: tingkatColors,
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverOffset: 15
                        }]
                    };
                    options = {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: {
                                        size: 13,
                                        weight: 'bold'
                                    },
                                    usePointStyle: true,
                                    boxWidth: 15,
                                    padding: 15
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.label || '';
                                        const value = context.raw || 0;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `${label}: ${value} lokasi (${percentage}%)`;
                                    }
                                }
                            },
                            title: {
                                display: true,
                                text: '📊 Ringkasan Tingkat Kerentanan',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                },
                                color: '#2c3e50',
                                padding: {
                                    bottom: 15
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 800
                        }
                    };
                }

                // Hancurkan chart lama jika ada
                if (currentChart) {
                    currentChart.destroy();
                }

                // Buat chart baru
                currentChart = new Chart(ctx, {
                    type: 'pie',
                    data: data,
                    options: options
                });
            }

            // Inisialisasi chart pertama kali
            renderChart();

            // Toggle button untuk beralih mode
            const toggleBtn = document.getElementById('toggleDetailBtn');
            const toggleText = document.getElementById('toggleText');

            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                isDetailMode = !isDetailMode;

                if (isDetailMode) {
                    toggleText.innerHTML = 'Tampilkan Ringkasan';
                    toggleBtn.style.background = 'var(--gradient-primary)';
                    toggleBtn.style.color = 'white';
                } else {
                    toggleText.innerHTML = 'Tampilkan Detail';
                    toggleBtn.style.background = '';
                    toggleBtn.style.color = '';
                }

                renderChart();
            });

            // Download chart sebagai gambar
            document.getElementById('downloadChartBtn').addEventListener('click', function(e) {
                e.preventDefault();
                const canvas = document.getElementById('disasterPieChart');
                const link = document.createElement('a');
                const title = isDetailMode ? 'detail-jenis-bencana' : 'ringkasan-tingkat-kerentanan';
                link.download = `grafik-${title}.png`;
                link.href = canvas.toDataURL('image/png');
                link.click();
            });

            // Fullscreen chart
            document.getElementById('fullscreenChartBtn').addEventListener('click', function(e) {
                e.preventDefault();
                const canvas = document.getElementById('disasterPieChart');
                if (canvas.requestFullscreen) {
                    canvas.requestFullscreen();
                } else if (canvas.webkitRequestFullscreen) {
                    canvas.webkitRequestFullscreen();
                } else if (canvas.msRequestFullscreen) {
                    canvas.msRequestFullscreen();
                }
            });
        });
    </script>
@endpush
