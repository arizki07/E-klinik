<?php

namespace App\Http\Controllers\_01_Master;

use App\Http\Controllers\Controller;
use App\Models\AntrianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Antrian extends Controller
{
    public function antr()
    {
        return view('pages.product.01_master.antrian');
    }

    public function store(Request $request)
    {
        $request->validate([
            'poli' => 'required|in:Poli Umum,Poli Gigi,Poli KB',
        ]);

        $poli = $request->input('poli');
        $lastAntrian = AntrianModel::where('service', $poli)->orderBy('created_at', 'desc')->first();

        if ($lastAntrian) {
            $lastNoAntrian = intval($lastAntrian->no_antrian);
            $newNoAntrian = str_pad($lastNoAntrian + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNoAntrian = '001';
        }

        AntrianModel::create([
            'nama_pasien' => Auth::user()->name,
            'no_antrian' => $newNoAntrian,
            'service' => $poli,
            'status' => 'menunggu',
        ]);

        return response()->json(['success' => true]);
    }
}
