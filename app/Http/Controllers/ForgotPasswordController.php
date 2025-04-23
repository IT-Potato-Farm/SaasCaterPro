<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    protected $throttleSeconds = 60;

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            ['email.exists' => 'This email is not registered']
        );

        // prevent more than 3 password reset attempts per minute
        $limiter = app(RateLimiter::class);
        $key = 'password-reset:' . $request->ip();

        if ($limiter->tooManyAttempts($key, 3)) {
            $seconds = $limiter->availableIn($key);
            return back()->withErrors([
                'email' => 'Too many password reset attempts. Please try again in ' . $seconds . ' seconds.'
            ]);
        }

        $limiter->hit($key);

        // Check if reset was requested recently
        $recentReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subSeconds($this->throttleSeconds))
            ->first();

        if ($recentReset) {
            return back()->with('success', 'A password reset link has already been sent to your email address.');
        }


        // Delete any existing tokens
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Generate plain + hashed token
        $plainToken = Str::random(64);
        $hashedToken = Hash::make($plainToken);
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $hashedToken,
            'created_at' => Carbon::now()
        ]);

        // Build reset URL with HTTPS (in production)
        $resetLink = url('reset-password/' . urlencode($plainToken) . '?email=' . urlencode($request->email));
        if (app()->environment('production')) {
            $resetLink = str_replace('http://', 'https://', $resetLink);
        }

        try {
            Mail::send('emails.password-reset', ['resetLink' => $resetLink], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Reset Password Notification');
            });

            return back()->with('success', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors(['email' => 'Unable to send password reset email. Please try again later.']);
        }
    }
}
