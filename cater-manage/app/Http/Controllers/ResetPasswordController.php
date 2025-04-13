<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    // MAXIMUM TOKEN EXPIRATION IN MINS
    protected $tokenExpiration = 60;

    public function showResetForm(Request $request, $token)
    {
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData || !Hash::check($token, $tokenData->token)) {
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid or expired password reset link.'
            ]);
        }

        // Check if token is expired
        $createdAt = Carbon::parse($tokenData->created_at);
        if ($createdAt->diffInMinutes(Carbon::now()) > $this->tokenExpiration) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return redirect()->route('login')
                ->withErrors(['email' => 'Password reset link has expired. Please request a new one.']);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function reset(Request $request)
    {
        Log::info('Reset form triggered', $request->all());
        // Validate request
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'max:16',
                'regex:/[a-z]/',      // at least one lowercase
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[0-9]/',      // at least one number
                function ($attribute, $value, $fail) {
                    if (!preg_match('/[a-z]/', $value)) {
                        $fail('The password must contain at least one lowercase letter.');
                    }
                    if (!preg_match('/[A-Z]/', $value)) {
                        $fail('The password must contain at least one uppercase letter.');
                    }
                    if (!preg_match('/[0-9]/', $value)) {
                        $fail('The password must contain at least one number.');
                    }
                },
                function ($attribute, $value, $fail) use ($request) {
                    $user = User::where('email', $request->email)->first();
                    if ($user && Hash::check($value, $user->password)) {
                        $fail('Your new password must be different from your current password.');
                    }
                },
            ],
            
            'token' => ['required', 'string']
        ]);

        // Retrieve and validate token
        $tokenData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }
        // Step 2: Check token
        if (!Hash::check($request->token, $tokenData->token)) {
            Log::warning('Token mismatch', [
                'submitted_token' => $request->token,
                'stored_token' => $tokenData->token
            ]);
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Check token expiration
        $createdAt = Carbon::parse($tokenData->created_at);
        if ($createdAt->diffInMinutes(Carbon::now()) > $this->tokenExpiration) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Password reset token has expired. Please request a new one.']);
        }

        // Rate limiting to prevent brute force
        try {
            $user = User::where('email', $request->email)->firstOrFail();
            // Hash the new password using Bcrypt
            $user->password = Hash::make($request->password);
            $user->remember_token = Str::random(60);
            $user->save();

            // Delete all password reset tokens for this user
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return redirect()->route('login')
                ->with('success', 'Your password has been changed successfully! You can now login with your new password.');
        } catch (\Exception $e) {
            report($e);
            return back()->withErrors(['error' => 'An error occurred while resetting your password. Please try again.']);
        }
    }
}
