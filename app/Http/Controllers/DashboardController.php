<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        return view('pages.dashboard');
    }

    public function getNotifications()
    {
        // Ambil data dari tabel users
        $users = User::select('id', 'name', 'roles', 'status', 'created_at')
            ->orderBy('created_at', 'desc') // Urutkan berdasarkan waktu pembuatan
            ->get();

        // Kembalikan data sebagai JSON
        return response()->json($users);
    }
}
