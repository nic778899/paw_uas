<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanAbsensi;
class PengaturanAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pengaturan_absensi = PengaturanAbsensi::all();
        return view('PengaturanAbsensi.index', compact('pengaturan_absensi'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validate = $request->validate([
            'check_in' => 'required',
            'check_out' => 'required',
            'rentang_awal_IP'=> 'required | regex:/^\S*$/',
            'rentang_akhir_IP' => 'required | regex:/^\S*$/'
        ]);

        $pengaturan_absensi = PengaturanAbsensi::find(1);
        $pengaturan_absensi->check_in = $validate['check_in'];
        $pengaturan_absensi->check_out = $validate['check_out'];
        $pengaturan_absensi->rentang_awal_IP = $validate['rentang_awal_IP'];
        $pengaturan_absensi->rentang_akhir_IP = $validate['rentang_akhir_IP'];
        $pengaturan_absensi->update();
        return redirect()->route('absensi.index')->with('sukses', 'Pengaturan absensi berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
