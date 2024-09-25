<?php

namespace App\Http\Controllers\Datatables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UsersList extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    return $this->getStatusBadge($row->status);
                })

                ->editColumn('select_orders', function ($row) {
                    return '';
                })
                ->rawColumns(['action', 'select_orders', 'status', 'tgl'])
                ->make(true);
        }

        return view('pages.product.00_home.users');
    }

    private function getStatusBadge($status)
    {
        switch ($status) {
            case 'PROSES PERSETUJUAN':
                return '<span class="status-dot status-dot-animated status-blue" style="font-size:11px"></span> <b class="text-blue">' . $status . '</b>';
            case 'ACC':
                return '<span class="status-dot status-dot-animated status-purple" style="font-size:11px"></span> <b class="text-purple">' . $status . '</b>';
            case 'HOLD':
                return '<span class="status-dot status-dot-animated status-orange" style="font-size:11px"></span> <b class="text-orange">' . $status . '</b>';
            case 'REJECT':
                return '<span class="status-dot status-dot-animated status-red" style="font-size:11px"></span> <b class="text-red">' . $status . '</b>';
            case 'PROSES PEMBELIAN':
                return '<span class="status-dot status-dot-animated status-lime" style="font-size:11px"></span> <b class="text-lime">' . $status . '</b>';
            case 'DIBELI':
                return '<span class="status-dot status-dot-animated status-green" style="font-size:11px"></span> <b class="text-green">' . $status . '</b>';
            case 'DITERIMA':
                return '<span class="status-dot status-dot-animated status-teal" style="font-size:11px"></span> <b class="text-teal">' . $status . '</b>';
            default:
                return '<span class="status-dot status-dot-animated status-dark"></span> <b class="text-dark">' . $status . '</b>';
        }
    }
}
