<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AntrianList extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = DB::table('pendaftaran')
            //     ->join('antrian', 'pendaftaran.nama_pasien', '=', 'antrian.nama_pasien')
            //     ->select(
            //         'pendaftaran.nama_pasien',
            //         'pendaftaran.ktp',
            //         'pendaftaran.tgl_lahir',
            //         'pendaftaran.alamat',
            //         'pendaftaran.no_tlpn',
            //         'pendaftaran.jenis_pasien',
            //         'pendaftaran.bpjs_status',
            //         'antrian.no_antrian',
            //         'antrian.service',
            //         'antrian.status'
            //     );
            $data = DB::table('antrian');
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-list flex-nowrap">
            <button class="btn btn-falcon-success me-1 mb-1 btn-sm" type="button" onclick="editData(' . $row->id . ')">
                <i class="far fa-edit" style="margin-right:5px;"></i>
            </button>
            <button class="btn btn-falcon-danger me-1 mb-1 btn-sm" type="button" onclick="deleteData(' . $row->id . ')">
                <i class="fas fa-trash"></i>
            </button>
            <button class="btn btn-falcon-info me-1 mb-1 btn-sm" type="button" onclick="playSound()">
                <i class="far fa-bell" style="margin-right:5px;"></i>
            </button>
        </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
