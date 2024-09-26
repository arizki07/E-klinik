<?php

namespace App\Http\Controllers\_01_master;

use App\Http\Controllers\Controller;
use App\Models\AntrianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    public function antrian()
    {
        return view('pages.product.01_master.antrian');
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli' => 'required|in:Poli Umum,Poli Gigi,Poli KB', // Sesuaikan dengan enum di database
        ]);

        // Logika untuk mengambil nomor antrian terbaru
        $poli = $request->input('poli');
        $lastAntrian = AntrianModel::where('service', $poli)->orderBy('created_at', 'desc')->first();

        if ($lastAntrian) {
            $lastNoAntrian = intval($lastAntrian->no_antrian);
            $newNoAntrian = str_pad($lastNoAntrian + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNoAntrian = '001';
        }

        // Simpan antrian baru ke database
        AntrianModel::create([
            'nama_pasien' => Auth::user()->name, // Sesuaikan dengan logika yang diinginkan
            'no_antrian' => $newNoAntrian,
            'service' => $poli,
            'status' => 'menunggu',
        ]);

        return response()->json(['success' => true]);
    }
}
