<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JabatanOrganisasi;
use App\Models\User;
use App\Models\DataPribadi;
use Illuminate\Support\Facades\Hash;
class KelolaPenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('KelolaPengguna.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $jabatan_organisasis = JabatanOrganisasi::all();
        return view('KelolaPengguna.create', compact('jabatan_organisasis'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'status' => 'required',
            'jabatan_organisasi_id' => 'required',
            'tanggal_lahir' => 'required',
            'tempat_lahir' => 'required'
        ]);

        $users = new User();
        $users->name = $validasi['name'];
        $users->email = $validasi['email'];
        $users->role = $validasi['status'];
        $users->password = Hash::make($validasi['password']);
        $users->save();
        $data_pribadis = new DataPribadi();
        $data_pribadis->jabatan_organisasi_id = $validasi['jabatan_organisasi_id'];
        $data_pribadis->tanggal_lahir = $validasi['tanggal_lahir'];
        $data_pribadis->tempat_lahir = $validasi['tempat_lahir'];
        $data_pribadis->user_id = User::where('email', $validasi['email'])->value('id');
        $data_pribadis->save();
        return redirect()->route('kelolapengguna.index')->with('sukses', 'Data pengguna berhasil ditambahkan!');
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
        $user = User::findOrFail($id);
        $jabatan_organisasis = JabatanOrganisasi::all();
        return view('KelolaPengguna.edit', compact('user', 'jabatan_organisasis'));
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
    // Temukan user berdasarkan ID
    $user = User::findOrFail($id);

    // Validasi data
    $validasi = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8',
        'status' => 'required|string',
        'jabatan_organisasi_id' => 'required|exists:jabatan_organisasis,id',
        'tanggal_lahir' => 'required|date',
        'tempat_lahir' => 'required|string|max:255'
    ]);

    // Update data user
    $user->name = $validasi['name'];
    $user->email = $validasi['email'];
    $user->role = $validasi['status'];
    if (!empty($validasi['password'])) {
        $user->password = Hash::make($validasi['password']);
    }
    $user->save();

    // Update data pribadi (cari berdasarkan user_id)
    $dataPribadi = DataPribadi::where('user_id', $user->id)->firstOrFail();
    $dataPribadi->jabatan_organisasi_id = $validasi['jabatan_organisasi_id'];
    $dataPribadi->tanggal_lahir = $validasi['tanggal_lahir'];
    $dataPribadi->tempat_lahir = $validasi['tempat_lahir'];
    $dataPribadi->save();

    // Redirect dengan pesan sukses
    return redirect()->route('kelolapengguna.index')->with('sukses', 'Data pengguna berhasil diperbarui!');
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
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('kelolapengguna.index')->with('sukses', 'Pengguna berhasil dihapus!');
    }
}
