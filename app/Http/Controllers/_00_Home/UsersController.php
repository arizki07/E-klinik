<?php

namespace App\Http\Controllers\_00_Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function users()
    {
        return view('pages.product.00_home.users');
    }
}
