<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    public function verifyNotice()
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        if ($user->email_verified_at !== null) {
            return redirect()->route('login')->with('message', 'Email already verified.');
        }

        if ($user->verification_code !== $request->code) {
            return back()->withErrors([
                'code' => 'Invalid verification code.',
            ]);
        }

        DB::table('users')->where('id', $user->id)->update([
            'email_verified_at' => now(),
            'verification_code' => null
        ]);

        $user = User::find($user->id);

        event(new Verified($user));

        session()->flash('message', 'Email successfully verified!');
        return redirect()->route('login');
    }

    public function verifyHandler(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized.');
        }

        $code = mt_rand(100000, 999999);

        DB::table('users')->where('id', $user->id)->update([
            'verification_code' => $code
        ]);

        Mail::send('emails.verify-code', ['code' => $code], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Email Verification Code');
        });

        return back()->with('message', 'Verification code sent!');
    }
}
