<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        // menghitung jumlah pengguna
        $jumlah_pengguna = DB::table('users')->count();

        // jumlah pengguna yang melakukan absensi hari ini
        $jumlah_pengguna_absensi_hari_ini = DB::table('absensis')->whereDate('created_at', Carbon::today())->count();


        // menghitung jumlah pegawai berdasarkan posisi/jabatan
        $jumlah_pegawai_berdasarkan_jabatan = DB::table('jabatan_organisasis')
            ->join('data_pribadis', 'jabatan_organisasis.id', '=', 'data_pribadis.jabatan_organisasi_id')
            ->select('jabatan_organisasis.nama_jabatan as jabatan', DB::raw('COUNT(data_pribadis.id) as jumlah'))
            ->groupBy('jabatan_organisasis.nama_jabatan')
            ->get();

        // menghitung jumlah pegawai yang melakukan absensi hari ini dan 2 hari kebelakang
        $data_absensi = DB::table('absensis')
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as jumlah'))
            ->whereBetween('created_at', [
                Carbon::now()->subDays(2)->startOfDay(), // Dua hari ke belakang
                Carbon::now()->endOfDay() // Hari ini
            ])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal', 'asc')
            ->get();
        return view('dashboard.index', compact('jumlah_pengguna', 'jumlah_pengguna_absensi_hari_ini', 'jumlah_pegawai_berdasarkan_jabatan', 'data_absensi'));
    }
}
