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
            $query = DB::table('pendaftaran')
                ->join('antrian', 'pendaftaran.nama_pasien', '=', 'antrian.nama_pasien')
                ->select(
                    'pendaftaran.nama_pasien',
                    'pendaftaran.ktp',
                    'pendaftaran.tgl_lahir',
                    'pendaftaran.alamat',
                    'pendaftaran.no_tlpn',
                    'pendaftaran.jenis_pasien',
                    'pendaftaran.bpjs_status',
                    'antrian.no_antrian',
                    'antrian.service',
                    'antrian.status'
                );
            return DataTables::of($query)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-list flex-nowrap">
                                <form method="POST" action="printPermintaan" target="_blank">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="noform" value="">
                                    <button type="submit" class="btn btn-sm btn-link btn-icon">
                                        <i class="fa-solid fa-print" style="margin-right:5px;"></i>
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-link align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-dots-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a href="#" class="dropdown-item edit-btn" data-bs-toggle="modal" data-bs-target="#modal" data-id="' . $row->id . '">
                                        <svg style="margin-right:5px;" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                        Edit
                                    </a>
                                    <a class="remove dropdown-item" href="javascript:void(0);" >
                                        <svg style="margin-right:5px;" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="1.5"  stroke-linecap="round"  stroke-linejoin="round"  class="icon text-red icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                        Hapus
                                    </a>'
                        . '</div>
                        </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
