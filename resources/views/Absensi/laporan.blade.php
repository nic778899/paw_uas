<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            font-size: 13px;
        }


        th,
        td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">Laporan Absensi</h1>
    <h5>Absensi Kehadiran</h5>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Waktu Absensi Kehadiran</th>
            <th>Keterangan</th>
        </tr>
        </thead>
        <tbody>
        @php
            $no = 1;
        @endphp
        @forelse ($absensisKehadiran as $absensi_hadir)
            <tr>
                <td>
                    <p class="font-weight-normal mb-0">{{ $no }}</p>
                    @php
                        $no++;
                    @endphp
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_hadir->user->name }}</p>
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_hadir->created_at }}</p>
                </td>
                <td>
                    <span class="badge bg-danger">{{ $absensi_hadir->status_absensi }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="font-weight-normal">
                    Tidak ada data absensi Hadir!
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <h5>Absensi Pulang</h5>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Waktu Absensi Pulang</th>
            <th>Keterangan</th>
        </tr>
        </thead>
        <tbody class="text-center" style="">
        @php
            $no = 1;
        @endphp
        @forelse ($absensisPulang as $absensi_pulang)
            <tr>
                <td>
                    <p class="font-weight-normal mb-0">{{ $no }}</p>
                    @php
                        $no++;
                    @endphp
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_pulang->user->name }}</p>
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_pulang->created_at }}</p>
                </td>
                <td>
                    <span class="badge bg-danger">{{ $absensi_pulang->status_absensi }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="font-weight-normal">
                    Tidak ada data absensi pulang!
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

    <h5>Absensi Izin</h5>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Waktu Absensi Izin</th>
            <th>Keterangan</th>
        </tr>
        </thead>
        <tbody class="text-center" style="">
        @php
            $no = 1;
        @endphp
        @forelse ($absensisIzin as $absensi_izin)
            <tr>
                <td>
                    <p class="font-weight-normal mb-0">{{ $no }}</p>
                    @php
                        $no++;
                    @endphp
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_izin->user->name }}</p>
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_izin->created_at }}</p>
                </td>
                <td>
                    <span class="badge bg-danger">{{ $absensi_izin->status_absensi }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="font-weight-normal">
                    Tidak ada data absensi Izin!
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

    <h5>Absensi Terlambat</h5>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Waktu Absensi Terlambat</th>
            <th>Keterangan</th>
        </tr>
        </thead>
        <tbody class="text-center" style="">
        @php
            $no = 1;
        @endphp
        @forelse ($absensisTerlambat as $absensi_terlambat)
            <tr>
                <td>
                    <p class="font-weight-normal mb-0">{{ $no }}</p>
                    @php
                        $no++;
                    @endphp
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_terlambat->user->name }}</p>
                </td>
                <td>
                    <p class="font-weight-normal mb-0">{{ $absensi_terlambat->created_at }}</p>
                </td>
                <td>
                    <span class="badge bg-danger">{{ $absensi_terlambat->status_absensi }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="font-weight-normal">
                    Tidak ada data absensi terlambat!
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>

    @if (auth()->user()->role === 'admin')
        <h2>Laporan Absensi</h2>
        <p>Periode: {{ $startDate->format('d-m-Y') }} s/d {{ $endDate->format('d-m-Y') }}</p>
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Gaji Pokok</th>
                <th>Kehadiran</th>
                <th>Izin</th>
                <th>Keterlambatan</th>
                <th>Pinalti Izin</th>
                <th>Pinalti Keterlambatan</th>
                <th>Total Pinalti</th>
                <th>Gaji Akhir</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nomor }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jabatan }}</td>
                    <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                    <td>{{ $item->kehadiran_format }}</td>
                    <td>{{ $item->izin }}</td>
                    <td>{{ $item->keterlambatan }}</td>
                    <td>Rp {{ number_format($item->pinalti_izin, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->pinalti_keterlambatan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_pinalti, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->gaji_akhir, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</body>

</html>
