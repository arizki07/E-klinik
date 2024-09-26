<?php

namespace App\Http\Controllers\_01_master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function antrian()
    {
        return view('pages.product.01_master.antrian');
    }
}
