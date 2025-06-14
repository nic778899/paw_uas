<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='kelolapengguna'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Kelola Pengguna"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid">
            @if (session('sukses'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success text-white" role="alert" id="pesan_sukses">
                            <strong>Berhasil!</strong> {{ session('sukses') }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('kelolapengguna.create') }}" class="btn btn-primary w-100">Tambah Pengguna</a>
                </div>
            </div>
            <div class="row">
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
                                            Email
                                        </th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                            Tanggal Lahir
                                        </th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                            Tempat Lahir
                                        </th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                            Jabatan
                                        </th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">
                                            Opsi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" style="">
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->data_pribadi->tanggal_lahir ?? 'null' }}</td>
                                            <td>{{ $user->data_pribadi->tempat_lahir ?? 'null' }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>{{ $user->data_pribadi->jabatan_organisasi->nama_jabatan ?? 'null' }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    @if ($user->id === 1)
                                                        <button class="btn btn-secondary mx-1" disabled>Edit</button>

                                                        <button class="btn btn-secondary mx-1" disabled>Hapus</button>
                                                    @else
                                                        <a href="{{ route('kelolapengguna.edit', $user->id) }}"
                                                            class="btn btn-warning mx-1">Edit</a>
                                                        <a href="#" class="btn btn-danger mx-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalHapus-{{ $user->id }}">Hapus</a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal untuk setiap jabatan -->
                                        <div class="modal fade" id="modalHapus-{{ $user->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Jabatan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus pengguna
                                                        "{{ $user->name }}"?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <form action="{{ route('kelolapengguna.destroy', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </tbody>
                            </table>
                            {{-- {{ $absensis->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function() {
            $("#pesan_sukses").delay(3000).fadeOut("slow");

            $('.btn-hapus').on('click', function() {
                const id = $(this).data('id');
                $('#jabatan-id').text(id); // Isi placeholder dengan ID
            });
        });
    </script>
</x-layout>
