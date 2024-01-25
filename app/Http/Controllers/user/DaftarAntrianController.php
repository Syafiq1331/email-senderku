<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Antrian;
use Illuminate\Support\Facades\Session;

class DaftarAntrianController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function store(Request $request)
    {
        // Validasi formulir
        $request->validate([
            'text' => 'required|string',
            'email' => 'required|email',
            'keperluan' => 'required',
            'fileSurat' => 'required|mimes:pdf|max:2048', // Contoh validasi file PDF dengan maksimum 2MB
        ]);

        // Simpan data ke dalam tabel Antrian
        $antrian = new Antrian;
        $antrian->name = $request->input('text');
        $antrian->email = $request->input('email');
        $antrian->keperluan = $request->input('keperluan');

        // Proses file surat
        if ($request->hasFile('fileSurat')) {
            $fileSurat = $request->file('fileSurat');
            $fileName = time() . '_' . $fileSurat->getClientOriginalName();
            $folderPath = 'surat_persyaratan_user'; // Nama folder yang diinginkan

            // Pindahkan file ke direktori tujuan
            $fileSurat->move(public_path($folderPath), $fileName);

            // Simpan path file surat ke dalam model
            $antrian->bukti_surat = $folderPath . '/' . $fileName;
        }

        $antrian->save();

        // Redirect atau lakukan aksi lainnya setelah penyimpanan
        // Set pesan sukses dalam session
        Session::flash('success', 'Anda telah melakukan peng-antrian. Silakan cek email secara berkala untuk informasi lebih lanjut.');

        // Redirect ke route /daftar-antrian
        return redirect()->route('daftar-antrian');
    }
}
