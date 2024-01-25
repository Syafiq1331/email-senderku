<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $antrian = Antrian::paginate(5); // Menggunakan paginate dengan 10 item per halaman, sesuaikan sesuai kebutuhan
        return view('Master.ListAntrian', compact('antrian'));
    }

    public function updateStatus($id)
    {
        $email = Antrian::findOrFail($id); // Gantilah YourModel dengan nama model yang sesuai

        $email->update([
            'status' => request('status'),
        ]);

        return redirect()->back();
    }
}
