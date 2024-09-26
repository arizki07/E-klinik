<?php

namespace App\Http\Controllers\_01_Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Pendaftaran extends Controller
{
    public function pendaftaran()
    {
        return view('pages.product.01_master.pendaftaran');
    }
}
