<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='kelolapengguna'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Kelola Pengguna"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('kelolapengguna.store') }}" method="post">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="input-group input-group-outline">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="nama" name="name" value="{{ old('name') }}">
                            </div>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <div class="input-group input-group-outline">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <div class="input-group input-group-outline">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                            </div>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <select name="jabatan_organisasi_id" id="jabatan_organisasi_id"
                                class="form-select px-3 @error('jabatan_organisasi_id') is-invalid @enderror">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($jabatan_organisasis as $jabatan_organisasi)
                                    <option value="{{ $jabatan_organisasi->id }}"
                                        {{ old('jabatan_organisasi_id') == $jabatan_organisasi->id ? 'selected' : '' }}>
                                        {{ $jabatan_organisasi->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jabatan_organisasi_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <select name="status" id="status"
                                class="form-select px-3 @error('status') is-invalid @enderror">
                                <option value="">Pilih Status</option>
                                <option value="admin">
                                    Admin
                                </option>
                                <option value="pegawai">
                                    Pegawai
                                </option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <div class="input-group input-group-outline is-filled">
                                <label class="form-label" for="tanggalLahir">Tanggal lahir</label>
                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    id="tanggalLahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                            </div>
                            @error('tanggal_lahir')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <div class="input-group input-group-outline">
                                <label class="form-label" for="tempatLahir">Tempat lahir</label>
                                <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    id="tempatLahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                            </div>
                            @error('tempat_lahir')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-layout>
