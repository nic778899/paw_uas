<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\PengaturanAbsensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 1. SYARAT ALAMAT IP
        $ip_pengguna = $request->ip();
        $hasil_cek_ip = PengaturanAbsensi::where('rentang_awal_IP', '<=', $ip_pengguna)
            ->where('rentang_akhir_IP', '>=', $ip_pengguna)
            ->exists();

        // 2. SYARAT TIDAK MELAKUKAN DOUBLE ABSENSI KEDATANGAN PADA HARI YANG SAMA
        $double_absensi_datang = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->whereIn('status_absensi', ['datang', 'terlambat', 'izin']) // Perbaikan disini
            ->exists();

        \Log::info($double_absensi_datang);
        //  3.FILTER


        $absensis = \App\Models\Absensi::query();
        $pengguna_aktif = Auth::user();

        // Terapkan filter berdasarkan input request
        if ($request->has('filter') && $request->filter === 'today') {
            $absensis->whereDate('created_at', Carbon::today());
        }

        if ($request->has('month') && $request->has('year')) {
            $absensis->whereYear('created_at', $request->input('year'))
                ->whereMonth('created_at', $request->input('month'));
        }

        // Filter Status Absensi jika ada
        if ($request->has('status_absensi')) {
            $absensis->where('status_absensi', $request->status_absensi);
        }

        // Jika pengguna adalah pegawai, hanya ambil absensinya sendiri
        if ($pengguna_aktif->role == 'pegawai') {
            $absensis->where('user_id', auth()->id());
        }

        // Ambil data setelah semua filter diterapkan
        $absensis = $absensis->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();


        // Dapatkan tahun yang tersedia dari data absensi
        $availableYears = \App\Models\Absensi::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');

        // Dapatkan bulan yang tersedia dari data absensi
        $availableMonths = \App\Models\Absensi::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year')
            ->distinct()
            ->get()
            ->map(function ($item) {
                $date = Carbon::create($item->year, $item->month, 1);
                return [
                    'key' => $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT),
                    'label' => $date->translatedFormat('F Y'),
                ];
            });
        // 5. DATA PENGATURAN ABSENSI
        $pengaturan_absensi = PengaturanAbsensi::find(1);
        $checkIn = $pengaturan_absensi->check_in;
        $checkOut = $pengaturan_absensi->check_out;

        // 6. CEK KETERLAMBATAN UNTUK MODAL ABSENSI
        $terlambat = null;
        if (Carbon::now()->between(Carbon::parse($pengaturan_absensi->check_in), Carbon::parse($pengaturan_absensi->check_out))) {
            $terlambat = true;
        }

        // 7. SYARAT DOUBLE ABSENSI PULANG DAN VALIDASI
        $double_absensi_pulang = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->where('status_absensi', 'pulang')
            ->exists();


        $waktu_absensi_pulang = Carbon::now()->greaterThan(
            Carbon::createFromFormat('H:i:s.u', $pengaturan_absensi->check_out)
        );

        $validasi_absensi_pulang = Absensi::where('user_id', auth()->id())
            ->whereIn('status_absensi', ['datang', 'terlambat'])
            ->whereDate('created_at', Carbon::today())
            ->exists();

        // 8. IZIN
        $izin = Absensi::where('user_id', auth()->id())
            ->whereDate('created_at', Carbon::today())
            ->where('status_absensi', 'izin')
            ->exists();

        return view('Absensi.index', compact(
            'hasil_cek_ip',
            'absensis',
            'terlambat',
            'pengaturan_absensi',
            'double_absensi_datang',
            'double_absensi_pulang',
            'waktu_absensi_pulang',
            'validasi_absensi_pulang',
            'availableYears',
            'availableMonths',
            'izin',
        ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validasi = $request->validate([
            'status_absensi' => 'required'
        ]);

        $ip_pengguna = auth()->id();

        // Batas maksimal waktu absensi
        $pengaturan_absensi = PengaturanAbsensi::find(1);
        $checkIn = Carbon::parse($pengaturan_absensi->check_in); // Waktu check-in
        $gracePeriod = 30; // Toleransi keterlambatan dalam menit

        $absensi = new Absensi();
        $absensi->user_id = auth()->id();

        // Ambil waktu sekarang sebagai objek Carbon
        $waktuSekarang = Carbon::now();

        // Batas akhir keterlambatan sebagai objek Carbon
        $batasTerlambat = Carbon::parse($checkIn)->addMinutes($gracePeriod);

        // Cek apakah user memilih "datang" dan melewati batas check-in
        if ($validasi['status_absensi'] === 'datang') {
            if ($waktuSekarang->greaterThan($batasTerlambat)) {
                // Jika lebih dari batas waktu toleransi, dianggap terlambat
                $absensi->status_absensi = 'terlambat';
            } else {
                // Jika masih dalam batas waktu toleransi, tetap dianggap "datang"
                $absensi->status_absensi = 'datang';
            }
        } else {
            // Jika status selain "datang", gunakan status asli
            $absensi->status_absensi = $validasi['status_absensi'];
        }

        $absensi->save();

        return redirect()->route('absensi.index')->with('sukses', 'Absensi berhasil dilakukan!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function downloadPDF(Request $request)
    {
        // Ambil tahun & bulan dari request atau gunakan default (bulan ini)
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->input('month', Carbon::now()->month);

        // Tentukan rentang waktu awal dan akhir dari bulan yang dipilih
        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

        // Ambil user yang sedang login
        $pengguna_aktif = Auth::user();

        // Query absensi berdasarkan peran user
        $absensis = Absensi::whereBetween('created_at', [$startDate, $endDate]);

        if ($pengguna_aktif->role == 'pegawai') {
            $absensis = $absensis->where('user_id', $pengguna_aktif->id);
        }

        // Eksekusi query untuk mendapatkan hasil
        $absensis = $absensis->orderBy('created_at', 'desc')->get();

        // Pisahkan absensi berdasarkan statusnya
        $absensisKehadiran = $absensis->where('status_absensi', 'datang');
        $absensisIzin = $absensis->where('status_absensi', 'izin');
        $absensisTerlambat = $absensis->where('status_absensi', 'terlambat');
        $absensisPulang = $absensis->where('status_absensi', 'pulang');

        // Query data gaji & keterlambatan
        $data = \DB::table('absensis')
            ->join('users', 'absensis.user_id', '=', 'users.id')
            ->join('data_pribadis', 'users.id', '=', 'data_pribadis.user_id')
            ->join('jabatan_organisasis', 'data_pribadis.jabatan_organisasi_id', '=', 'jabatan_organisasis.id')
            ->join('pengaturan_absensis', \DB::raw('1'), '=', \DB::raw('1')) // Join dummy
            ->select(
                'users.name as nama',
                'jabatan_organisasis.nama_jabatan as jabatan',
                'jabatan_organisasis.besaran_gaji as gaji_pokok',
                \DB::raw('COUNT(CASE WHEN absensis.status_absensi = "datang" THEN 1 END) as kehadiran'),
                \DB::raw('COUNT(CASE WHEN absensis.status_absensi = "izin" THEN 1 END) as izin'),
                \DB::raw('COUNT(CASE WHEN absensis.status_absensi = "terlambat" THEN 1 END) as keterlambatan')
            )
            ->whereBetween('absensis.created_at', [$startDate, $endDate])
            ->groupBy('users.id', 'jabatan_organisasis.nama_jabatan', 'jabatan_organisasis.besaran_gaji')
            ->get();

        // Perhitungan gaji & pinalti
        foreach ($data as $index => $item) {
            $item->nomor = $index + 1;
            $item->total_hari = $startDate->diffInDays($endDate) + 1;
            $item->kehadiran_format = "{$item->kehadiran}/{$item->total_hari}";
            $item->pinalti_izin = max(0, ($item->izin - 3) * 50000);
            $item->pinalti_keterlambatan = $item->keterlambatan * 25000;
            $item->total_pinalti = $item->pinalti_izin + $item->pinalti_keterlambatan;
            $item->gaji_akhir = $item->gaji_pokok - $item->total_pinalti;
        }

        // Ambil data pengaturan absensi
        $pengaturan_absensi = PengaturanAbsensi::find(1);

        // Generate PDF
        $pdf = Pdf::loadView('Absensi.laporan', compact(
            'data', 'startDate', 'endDate', 'absensis',
            'absensisKehadiran', 'absensisIzin', 'absensisTerlambat', 'absensisPulang',
            'pengaturan_absensi'
        ))->setPaper('f4', 'landscape');

        // Unduh PDF dengan nama file yang mencantumkan periode
        return $pdf->download("laporan_absensi_{$selectedYear}_{$selectedMonth}.pdf");
    }
}
