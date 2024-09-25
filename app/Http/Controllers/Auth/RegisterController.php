<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MailSend;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        return view('auth.register');
    }

    public function actionRegist(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'pasien',
            'status' => 'inactive'
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);

        Otp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => $expiresAt
        ]);

        // Send OTP email
        $details = [
            'name' => $user->name,
            'otp' => $otp,
            'expires_at' => $expiresAt->format('Y-m-d H:i:s')
        ];

        try {
            Mail::to($request->email)->send(new MailSend($details));
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Mail sending failed.');
        }

        Session::put('email', $request->email);

        Session::flash('message', 'OTP telah dikirim ke Email Anda. Silahkan cek Email Anda untuk verifikasi akun.');
        return redirect()->route('otp.form');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $email = Session::get('email');

        if (!$email) {
            return back()->with('error', 'Email session not found. Please try again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found!');
        }

        $otpRecord = Otp::where('user_id', $user->id)->where('otp', $request->otp)->first();

        if (!$otpRecord) {
            return back()->with('error', 'Invalid OTP!');
        }

        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return back()->with('error', 'OTP has expired!');
        }

        $user->update([
            'email_verified_at' => now(),
            'status' => 'active'
        ]);

        $otpRecord->delete();
        Session::forget('email');

        return redirect('/')->with('success', 'Verification successful! Your account is now active.');
    }

    public function otp()
    {
        return view('auth.otp');
    }
}
