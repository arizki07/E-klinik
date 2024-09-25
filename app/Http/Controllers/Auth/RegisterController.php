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
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => 'pasien',
            'status' => 'inactive'
        ]);

        // Generate OTP
        $otp = rand(100000, 999999);  // 6-digit OTP
        $expiresAt = Carbon::now()->addMinutes(5);  // OTP expires in 5 minutes

        // Save OTP to database
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

        // Store email in session for OTP verification
        Session::put('email', $request->email);

        // Flash success message and redirect to OTP form
        Session::flash('message', 'OTP telah dikirim ke Email Anda. Silahkan cek Email Anda untuk verifikasi akun.');
        return redirect()->route('otp.form'); // Redirect to OTP form
    }

    public function verifyOtp(Request $request)
    {
        // Validate OTP input
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        // Retrieve the email from the session
        $email = Session::get('email');

        // Debugging: Check if email is in session
        if (!$email) {
            return back()->with('error', 'Email session not found. Please try again.');
        }

        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found!');
        }

        // Find the OTP record for the user
        $otpRecord = Otp::where('user_id', $user->id)->where('otp', $request->otp)->first();

        if (!$otpRecord) {
            return back()->with('error', 'Invalid OTP!');
        }

        // Check if OTP has expired
        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return back()->with('error', 'OTP has expired!');
        }

        // Activate the user and mark the email as verified
        $user->update([
            'email_verified_at' => now(),
            'status' => 'active'
        ]);

        // Delete the OTP record after successful verification
        $otpRecord->delete();

        // Clear the email from the session
        Session::forget('email');

        // Redirect or show success message after verification
        return redirect('/')->with('success', 'Verification successful! Your account is now active.');
    }

    public function otp()
    {
        return view('auth.otp');
    }
}
