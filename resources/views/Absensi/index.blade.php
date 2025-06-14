<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='absensi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Absensi"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid">
            @if (session('sukses'))
                <div class="row">
                    <div class="alert alert-success text-white" role="alert" id="pesan_sukses">
                        <strong>Berhasil!</strong> {{ session('sukses') }}
                    </div>
                </div>
            @endif
            @if (Auth()->user()->role == 'admin')
                <div class="row">
                    <div class="col-12 p-0">
                        <a href="{{ route('pengaturanabsensi.index') }}" class="btn btn-primary w-100">Pengaturan
                            absensi</a>
                    </div>
                </div>
            @endif

            @if (Auth()->user()->role == 'pegawai')
                <div class="row">
                    @if ($hasil_cek_ip)
                        {{-- <a href="{{ route('absensi.create') }}" class="btn btn-primary mb-4 w-100"
                            data-bs-toggle="modal" data-bs-target="#modal_absensi">Absensi</a> --}}

                        <button type="button" class="btn btn-primary mb-4 w-100" data-bs-toggle="modal"
                                data-bs-target="#absensiModal">
                            Absensi
                        </button>
                    @else
                        <p class="m-0"><small>Absensi tidak tersedia! anda berada di luar jangkauan
                                jaringan!</small>
                        </p>
                    @endif
                </div>
            @endif


            <div class="row">
                <div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="absensiForm" method="POST" action="{{ route('absensi.store') }}">
                                @csrf
                                <div class="modal-header d-flex justify-content-center">
                                    <h5 class="modal-title" id="absensiModalLabel">Absensi</h5>
                                </div>
                                <div class="modal-body">
                                    <!-- Navigasi Tabs -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="masuk-tab" data-bs-toggle="tab"
                                                    data-bs-target="#masuk" type="button" role="tab"
                                                    aria-controls="masuk" aria-selected="true">Absensi Masuk
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pulang-tab" data-bs-toggle="tab"
                                                    data-bs-target="#pulang" type="button" role="tab"
                                                    aria-controls="pulang" aria-selected="false">Absensi Pulang
                                            </button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <!-- Tab Absensi Masuk -->
                                        <div class="tab-pane fade show active" id="masuk" role="tabpanel"
                                             aria-labelledby="masuk-tab">
                                            <p>Form absensi kedatangan</p>
                                            <div class="form-check">
                                                @if ($double_absensi_datang)
                                                    <input class="form-check-input absensi-radio" type="radio"
                                                           name="status_absensi" id="absensi_datang" value="datang"
                                                           disabled>
                                                    <label class="form-check-label text-disabled"
                                                           for="absensi_datang">Datang <span class="text-danger">(Anda
                                                            sudah
                                                            melakukan absensi kedatangan hari ini!)</span></label>
                                                    <input class="form-check-input absensi-radio" type="radio"
                                                           name="status_absensi" id="absensi_izin" value="izin"
                                                           disabled>
                                                    <label class="form-check-label text-disabled"
                                                           for="absensi_izin">Izin <span class="text-danger">(Anda
                                                            sudah
                                                            melakukan absensi izin hari ini!)</span></label>
                                                @elseif(!$double_absensi_datang)
                                                    <input class="form-check-input absensi-radio" type="radio"
                                                           name="status_absensi" id="absensi_datang" value="datang">
                                                    <label class="form-check-label" for="absensi_datang">Datang</label>

                                                    <input class="form-check-input absensi-radio" type="radio"
                                                           name="status_absensi" id="izin" value="izin">
                                                    <label class="form-check-label" for="izin">Izin</label>
                                                @endif


                                            </div>
                                        </div>
                                        <!-- Tab Absensi Pulang -->
                                        <div class="tab-pane fade" id="pulang" role="tabpanel"
                                             aria-labelledby="pulang-tab">
                                            <p>Anda hanya dapat melakukan absensi pulang jika telah melakukan absensi
                                                kedatangan</p>
                                            <div class="form-check">
                                                <!-- cek apakah sudah lakukan absensi datang -->
                                                @if ($validasi_absensi_pulang)
                                                    @if (!$double_absensi_pulang)
                                                        <input class="form-check-input absensi-radio" type="radio"
                                                               name="status_absensi" id="absensi_pulang" value="pulang">
                                                        <label class="form-check-label"
                                                               for="absensi_pulang">Pulang</label>
                                                    @else
                                                        <input class="form-check-input absensi-radio" type="radio"
                                                               name="status_absensi" id="absensi_pulang" value="pulang"
                                                               disabled>
                                                        <label class="form-check-label text-disabled"
                                                               for="absensi_pulang">Pulang <span
                                                                class="text-danger">(Anda
                                                                sudah melakukan absensi
                                                                pulang hari ini!)</span></label>
                                                    @endif
                                                @elseif($izin)
                                                    <input class="form-check-input absensi-radio" type="radio"
                                                           name="status_absensi" id="absensi_pulang" value="pulang"
                                                           disabled>
                                                    <label class="form-check-label text-disabled"
                                                           for="absensi_pulang">Pulang <span class="text-danger">(Anda
                                                            melakukan izin hari ini!)</span></label>
                                                @else
                                                    <input class="form-check-input absensi-radio" type="radio"
                                                           name="status_absensi" id="absensi_pulang" value="pulang"
                                                           disabled>
                                                    <label class="form-check-label text-disabled"
                                                           for="absensi_pulang">Pulang <span class="text-danger">(Isi
                                                            terlebih dahulu absensi datang!)</span></label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup
                                    </button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Baris Filter -->
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Bagian Kiri: Filter Hari Ini, Tahun, Bulan -->
                        <div class="d-flex gap-2 align-items-center">
                            <!-- Filter Hari Ini -->
                            <a href="{{ route('absensi.index', ['filter' => 'today']) }}" class="btn btn-primary mt-3">
                                Hari Ini
                            </a>
                            <!-- Button Filter Bulan -->
                            <button class="filter-btn btn btn-primary m-0" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                Filter Bulanan
                            </button>
                            <ul class="dropdown-menu">
                                {{-- Date Picker filter bulan --}}
                                <div class="mx-3 my-2">
                                    <div class="container">
                                        <div class="mb-2">
                                            <label for="filterMonth" class="form-label m-0">Pilih Bulan</label>
                                            <input type="month" id="filterMonth" class="form-control"
                                                   value="{{ request()->input('month', \Carbon\Carbon::now()->format('Y-m')) }}">
                                        </div>
                                        <button class="btn btn-outline-info m-0 w-100" id="applyMonthFilter">Terapkan
                                        </button>
                                    </div>
                                </div>
                            </ul>
                            <button class="filter-btn btn btn-primary m-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Filter Status
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item filter-status"
                                       href="{{ url()->current() . '?' . http_build_query(request()->except('status_absensi')) }}"
                                       data-status="">
                                        Semua
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item filter-status" href="{{ request()->fullUrlWithQuery(['status_absensi' => 'datang']) }}" data-status="datang">Datang</a>
                                </li>
                                <li>
                                    <a class="dropdown-item filter-status" href="{{ request()->fullUrlWithQuery(['status_absensi' => 'izin']) }}" data-status="izin">Izin</a>
                                </li>
                                <li>
                                    <a class="dropdown-item filter-status" href="{{ request()->fullUrlWithQuery(['status_absensi' => 'terlambat']) }}" data-status="terlambat">Terlambat</a>
                                </li>
                                <li>
                                    <a class="dropdown-item filter-status" href="{{ request()->fullUrlWithQuery(['status_absensi' => 'pulang']) }}" data-status="pulang">Pulang</a>
                                </li>
                            </ul>
                        </div>
                        <!-- Bagian Kanan: Tombol Unduh PDF -->
                        <form method="GET" action="{{ route('absensi.download-pdf') }}" class="d-inline-block"
                              style="margin-top: 15px;">
                            <input type="hidden" name="month" value="{{ request('month') }}">
                            <input type="hidden" name="year" value="{{ request('year') }}">
                            <button type="submit" class="btn btn-success">Unduh PDF</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12 p-0 mt-2">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="absensi-table">
                                <thead class="text-center">
                                <tr>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        Nama
                                    </th>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        Waktu absensi
                                    </th>
                                    <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                        Keterangan
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="text-center" style="">
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($absensis as $absensi)
                                    <tr>
                                        <td>
                                            <p class="font-weight-normal mb-0">{{ $no }}</p>
                                            @php
                                                $no++;
                                            @endphp
                                        </td>
                                        <td>
                                            <p class="font-weight-normal mb-0">{{ $absensi->user->name }}</p>
                                        </td>
                                        <td>
                                            <p class="font-weight-normal mb-0">{{ $absensi->created_at }}</p>
                                        </td>
                                        <td>
                                            @if($absensi->status_absensi == 'terlambat')
                                                <span class="badge bg-danger">{{ $absensi->status_absensi }}</span>
                                            @else
                                                {{ $absensi->status_absensi }}
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="font-weight-normal">
                                            Tidak ada data absensi!
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modal_absensi" tabindex="-1" role="dialog"
             aria-labelledby="modal_absensiLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="d-flex modal-title font-weight-normal gap-1">
                            <h5 class="" id="exampleModalLabel">Absensi</h5>
                            @if ($terlambat == true)
                                <span class="badge bg-danger d-flex align-items-center">Terlambat!</span>
                            @endif
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('absensi.store') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_absensi"
                                       id="status_absensi" value="hadir">
                                <label class="custom-control-label" for="status_absensi">Hadir</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-gradient-secondary"
                                    data-bs-dismiss="modal">Tutup
                            </button>
                            <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#pesan_sukses").delay(3000).fadeOut("slow");
                let currentFilter = {};

                document.getElementById('applyMonthFilter').addEventListener('click', function () {
                    let selectedMonth = document.getElementById('filterMonth').value; // Format: YYYY-MM
                    if (selectedMonth) {
                        let [year, month] = selectedMonth.split('-'); // Pisahkan Tahun & Bulan
                        let url = new URL(window.location.href);
                        url.searchParams.delete('filter', 'today');
                        url.searchParams.set('year', year); // Tambahkan parameter tahun
                        url.searchParams.set('month', month); // Tambahkan parameter bulan
                        window.location.href = url.toString();
                    }
                });


                $('.download-pdf').on('click', function (e) {
                    e.preventDefault();

                    // Ambil nilai bulan dan tahun dari URL (jika ada)
                    let url = new URL("{{ route('absensi.download-pdf') }}", window.location.origin);
                    let params = new URLSearchParams(window.location.search);

                    if (params.has('month')) {
                        url.searchParams.set('month', params.get('month'));
                    }
                    if (params.has('year')) {
                        url.searchParams.set('year', params.get('year'));
                    }

                    // Redirect ke URL dengan parameter yang benar
                    window.location.href = url.toString();
                });
            })
        </script>
    </main>
</x-layout>
