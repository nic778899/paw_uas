<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row d-flex justify-content-center">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">person</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Jumlah Pengguna</p>
                                <h4 class="mb-0">{{ $jumlah_pengguna }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Jumlah pengguna
                                aplikasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div
                                class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">weekend</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Absensi hari ini</p>
                                <h4 class="mb-0">{{ $jumlah_pengguna_absensi_hari_ini }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Jumlah pengguna absensi hari ini</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 d-flex justify-content-center">
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2 ">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0 ">Jumlah Pegawai Berdasarkan Jabatan</h6>
                            <p class="text-sm">Data terbaru</p>
                            <hr class="dark horizontal">
                            <div class="d-flex ">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm"> Data diperbarui secara real-time </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                            <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                <div class="chart">
                                    <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-0">Absensi Harian</h6>
                            <p class="text-sm">Data untuk hari ini dan 2 hari terakhir.</p>
                            <hr class="dark horizontal">
                            <div class="d-flex">
                                <i class="material-icons text-sm my-auto me-1">schedule</i>
                                <p class="mb-0 text-sm">Diperbarui secara real-time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>
    <x-plugins></x-plugins>
    </div>
    @push('js')
        <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data dari backend (diinject melalui Laravel Blade)
                const chartData = @json($data_absensi);

                // Parse data untuk sumbu X (tanggal) dan sumbu Y (jumlah kehadiran)
                const labels = chartData.map(data => data.tanggal);
                const data = chartData.map(data => data.jumlah);

                // Inisialisasi Chart.js
                const ctx = document.getElementById('chart-line').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Kehadiran',
                            data: data,
                            fill: false,
                            borderColor: 'rgba(72, 239, 125, 1)',
                            backgroundColor: 'rgba(72, 239, 125, 0.5)',
                            borderWidth: 2,
                            tension: 0.4 // Membuat garis lebih halus
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'white' // Warna teks pada legenda
                                }
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal',
                                    color: 'white' // Warna teks label sumbu X
                                },
                                ticks: {
                                    color: 'white' // Warna angka pada sumbu X
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Kehadiran',
                                    color: 'white' // Warna teks label sumbu Y
                                },
                                ticks: {
                                    color: 'white' // Warna angka pada sumbu Y
                                }
                            }
                        }
                    }
                });
            });


            document.addEventListener('DOMContentLoaded', function() {
                // Data dari backend (diinject melalui Laravel Blade)
                const chartData = @json($jumlah_pegawai_berdasarkan_jabatan);

                // Parse data untuk sumbu x (nama jabatan) dan sumbu y (jumlah pegawai)
                const labels = chartData.map(data => data.jabatan);
                const data = chartData.map(data => data.jumlah);

                // Inisialisasi Chart.js
                const ctx = document.getElementById('chart-bars').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: data,
                            backgroundColor: 'rgba(72, 125, 239, 0.7)',
                            borderColor: 'rgba(72, 125, 239, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                labels: {
                                    color: 'white', // Warna teks pada legenda
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jabatan',
                                    color: 'white', // Warna teks label sumbu X
                                },
                                ticks: {
                                    color: 'white', // Warna angka pada sumbu X
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Pegawai',
                                    color: 'white', // Warna teks label sumbu Y
                                },
                                ticks: {
                                    color: 'white', // Warna angka pada sumbu Y
                                }
                            }
                        }
                    }
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush
</x-layout>
