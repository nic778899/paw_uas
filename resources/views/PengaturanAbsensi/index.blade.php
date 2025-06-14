<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='absensi'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Pengaturan waktu absensi"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <form action="{{ route('pengaturanabsensi.update', [($id = 1)]) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="row my-3">
                        <div class="col-xl-6 col-sm-12">
                            <div class="input-group input-group-static">
                                <label for="check_in">Absen datang</label>
                                <input type="time" class="form-control" id="check_in" name="check_in"
                                    value="{{ $pengaturan_absensi[0]->check_in }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <div class="input-group input-group-static">
                                <label for="check_out">Absen Pulang</label>
                                <input type="time" class="form-control" id="check_out" name="check_out"
                                    value="{{ $pengaturan_absensi[0]->check_out }}">
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-xl-6 col-sm-12">
                            <div class="input-group input-group-outline is-filled">
                                <label class="form-label"for="rentang_awal_IP">Batas bawah alamat IP</label>
                                <input type="text" class="form-control" id="rentang_awal_IP" name="rentang_awal_IP"
                                    value="{{ $pengaturan_absensi[0]->rentang_awal_IP }}">
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-12">
                            <div class="input-group input-group-outline is-filled">
                                <label class="form-label"for="rentang_akhir_IP">Batas atas alamat IP</label>
                                <input type="text" class="form-control" id="rentang_akhir_IP" name="rentang_akhir_IP"
                                    value="{{ $pengaturan_absensi[0]->rentang_akhir_IP }}">
                            </div>
                        </div>

                        <div class="row my-3 mx-0">
                            <div class="col-xl-6 col-sm-12">
                                @error('rentang_awal_ip')
                                    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                                        <span class="alert-icon align-middle">
                                            <span class="material-icons text-md text-white">
                                                thumb_up_off_alt
                                            </span>
                                        </span>
                                        <span class="text-white"><strong>Danger!</strong> {{ $message }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-xl-6 col-sm-12">
                                @error('rentang_akhir_ip')
                                    <div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
                                        <span class="alert-icon align-middle">
                                            <span class="material-icons text-md text-white">
                                                thumb_up_off_alt
                                            </span>
                                        </span>
                                        <span class="text-white"><strong>Danger!</strong> {{ $message }}</span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row p-0">
                            <div class="col-xl-12">
                                <button class="btn btn-primary w-100" type="submit">Simpan</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </main>
</x-layout>
