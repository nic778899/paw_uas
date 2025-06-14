<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='kelolajabatan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Absensi"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid">
            <form action="{{ route('kelolajabatan.update', $jabatan_organisasi->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="input-group input-group-outline is-filled">
                            <label class="form-label"for="namaJabatan">Nama jabatan</label>
                            <input type="text" class="form-control" id="namaJabatan" name="nama_jabatan"
                                value="{{ $jabatan_organisasi->nama_jabatan }}">
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-12">
                        <div class="input-group input-group-outline is-filled">
                            <label class="form-label"for="namaJabatan">Nama jabatan</label>
                            <input type="text" class="form-control" id="namaJabatan" name="besaran_gaji"
                                value="{{ $jabatan_organisasi->besaran_gaji }}">
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </main>
</x-layout>
