<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\EmailHistory;
use Illuminate\Http\Request;

class DashboardControler extends Controller
{
    public function index()
    {
        $emailHistory = EmailHistory::paginate(10);
        return view('dashboard', compact('emailHistory'));
    }

    public function destroy($id)
    {
        // Lakukan logika penghapusan di sini
        // Contoh: hapus record dari database
        EmailHistory::findOrFail($id)->delete();

        return response()->json(['success' => true, 'message' => 'Email History berhasil dihapus']);
    }
}
