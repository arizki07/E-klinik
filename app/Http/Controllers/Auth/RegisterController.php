<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'user', // Atur peran default sebagai user biasa
            'status' => 'pending',
            'email_verified_at' => null,
            'remember_token' => Str::random(60),
        ]);

        // Kirim email verifikasi
        $this->sendVerificationEmail($user);

        return response()->json(['message' => 'User registered successfully. Please check your email to verify your account.']);
    }

    protected function sendVerificationEmail($user)
    {
        $token = $user->remember_token;
        $verificationUrl = route('verification.verify', ['token' => $token, 'email' => $user->email]);

        // Kirim email
        Mail::send('emails.verify', ['user' => $user, 'url' => $verificationUrl], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verify Your Email Address');
        });
    }

    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('remember_token', $request->token)
            ->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->status = 'active';
            $user->save();

            return redirect('/')->with('message', 'Email verified successfully.');
        }

        return redirect('/')->with('error', 'Invalid verification link.');
    }
}
