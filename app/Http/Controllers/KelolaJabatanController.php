<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanOrganisasi;
class KelolaJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jabatan_organisasis = JabatanOrganisasi::all();
        return view('KelolaJabatan.index', compact('jabatan_organisasis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('KelolaJabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validasi = $request->validate([
            'nama_jabatan' => 'required',
            'besaran_gaji'=> 'required'
        ]);

        $jabatanOrganisasi = new JabatanOrganisasi();
        $jabatanOrganisasi->nama_jabatan = $validasi['nama_jabatan'];
        $jabatanOrganisasi->besaran_gaji = $validasi['besaran_gaji'];
        $jabatanOrganisasi->save();

        return redirect()->route('kelolajabatan.index')->with('sukses', 'Jabatan berhasil ditambahkan berhasil dilakukan!');
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
        $jabatan_organisasi = JabatanOrganisasi::findOrFail($id);
        return view('KelolaJabatan.edit', compact('jabatan_organisasi'));
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
         $validasi = $request->validate([
            'nama_jabatan' => 'required',
            'besaran_gaji'=> 'required'
        ]);

        $jabatan_organisasi = JabatanOrganisasi::findOrFail($id);
        $jabatan_organisasi->nama_jabatan = $validasi['nama_jabatan'];
        $jabatan_organisasi->besaran_gaji = $validasi['besaran_gaji'];
        $jabatan_organisasi->update();
        
        return redirect()->route('kelolajabatan.index')->with('sukses', 'Data jabatan berhasil diubah!');
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
        $jabatan_organisasi = JabatanOrganisasi::findOrFail($id);
        $jabatan_organisasi->delete();
         return redirect()->route('kelolajabatan.index')->with('sukses', 'Data jabatan berhasil dihapus!');
    }
}
