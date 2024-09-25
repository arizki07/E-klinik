<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class ForgotController extends Controller
{
    public function index()
    {
        return view('auth.forgot');
    }

    public function submitForgotPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            $token = Str::random(64);

            DB::table('users')->where('email', $request->email)->update([
                'remember_token' => $token,
                'updated_at' => Carbon::now(),
            ]);

            Mail::send('emails.reset-mail', ['token' => $token, 'email' => $request->email], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password');
            });

            Log::info('Reset password email sent to: ' . $request->email);

            Session::flash('Link Success', 'Reset Link Sent Successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error sending reset password email: ' . $e->getMessage());
            Session::flash('link_error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function showResetPasswordForm($token)
    {
        $email = request()->query('email');
        return view('auth.reset', ['token' => $token, 'email' => $email]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        try {
            $user = User::where('remember_token', $request->token)->first();

            if (!$user) {
                return back()->withInput()->with('error', 'Invalid token!');
            }

            $user->update([
                'password' => Hash::make($request->new_password),
                'remember_token' => Str::random(60)
            ]);

            return redirect('/')->with('success', 'Your password has been changed!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
