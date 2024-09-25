<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()->all()
            ]);
        } else {
            $user = User::where('email', $request->email)->first();

            if ($user->status === 'inactive') {
                return response()->json([
                    "status" => false,
                    "header" => "Account Inactive",
                    "errors" => ["Your account is inactive. Please verify your account before logging in."]
                ]);
            }

            $rememberMe = $request->remember ? true : false;
            $up = $request->only(["email", "password"]);

            if (Auth::attempt($up, $rememberMe)) {
                return response()->json([
                    "status" => true,
                    "redirect" => url("dashboard")
                ]);
            } else {
                return response()->json([
                    "status" => false,
                    "header" => "Invalid credentials",
                    "errors" => ["Check your email & password"]
                ]);
            }
        }
    }



    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
