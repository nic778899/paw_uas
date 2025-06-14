<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='catatangaji'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Catatan Gaji"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid d-flex justify-content-center align-items-center">
            @if ($user)
                <div class="col-4" style="margin-bottom: 10px">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <span class="material-icons text-primary me-2" style="font-size: 36px;">
                                    person
                                </span>
                                <h5 class="card-title mb-0">{{ $user->name }}</h5>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="material-icons text-success me-2">
                                    paid
                                </span>
                                <p class="mb-0">Gaji:
                                    <strong>{{ $user->data_pribadi->jabatan_organisasi->besaran_gaji }}</strong>
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="material-icons text-warning me-2">
                                    work
                                </span>
                                <p class="mb-0">Jabatan:
                                    <strong>{{ $user->data_pribadi->jabatan_organisasi->nama_jabatan }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @foreach ($users as $user)
                    @if ($user->id === 1)
                    @else
                        <div class="col-4 mx-3" style="margin-bottom: 10px">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="material-icons text-primary me-2" style="font-size: 36px;">
                                            person
                                        </span>
                                        <h5 class="card-title mb-0">{{ $user->name }}</h5>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="material-icons text-success me-2">
                                            paid
                                        </span>
                                        <p class="mb-0">Gaji:
                                            <strong>{{ $user->data_pribadi->jabatan_organisasi->besaran_gaji ?? 'null' }}</strong>
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="material-icons text-warning me-2">
                                            work
                                        </span>
                                        <p class="mb-0">Jabatan:
                                            <strong>{{ $user->data_pribadi->jabatan_organisasi->nama_jabatan ?? 'null' }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

        </div>
    </main>
</x-layout>
