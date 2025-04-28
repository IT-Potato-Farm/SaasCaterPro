<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CheckoutController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class UserController extends Controller
{
    public function goregister()
    {
        if (Auth::check()) {
            return redirect()->route('landing');
        }

        // If not logged in
        return view('register')->with('message', session('message', ''));
    }


    public function gologin()
    {
        if (Auth::check()) {
            return redirect()->route('landing');
        }

        // If not logged in
        return view('loginpage')->with('message', session('message', ''));
    }

    public function login(Request $request)
    {
        $loginInfo = $request->validate([
            'loginemail' => ['required', 'email'],
            'loginpassword' => ['required', 'string', 'min:8']
        ], [
            'loginemail.required' => 'The email field is required.',
            'loginemail.email' => 'Please enter a valid email address.',
            'loginpassword.required' => 'The password field is required.',
            'loginpassword.min' => 'The password must be at least 8 characters.'
        ]);

        // check if nage-exist email
        $user = User::where('email', $loginInfo['loginemail'])->first();

        if (!$user) {
            return back()->withErrors([
                'loginemail' => 'Email does not exist.',
            ])->onlyInput('loginemail');
        }

        //  authenticate the user
        if (Auth::attempt([
            'email' => $loginInfo['loginemail'],
            'password' => $loginInfo['loginpassword']
        ])) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (session()->has('guest_cart')) {
                // Instantiate CheckoutController
                $checkoutController = new CheckoutController();

                // Call mergeGuestCart method
                $checkoutController->mergeGuestCart($user, session()->get('guest_cart'));
                Log::info('Merging guest cart and clearing session.');
                // Clear guest cart from session
                session()->forget('guest_cart');
                session()->save();
                if (!session()->has('guest_cart')) {
                    Log::info('Guest cart session is cleared successfully!');
                } else {
                    Log::warning('Failed to clear guest cart session.');
                }
            }
            // if admin punta dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.reports')->with('success', 'Login successful!');
            } else {
                return redirect()->route('landing')->with('success', 'Login successful!');
            }
        }


        return back()->withErrors([
            'loginpassword' => 'Password is incorrect.',
        ])->onlyInput('loginemail');
    }

    public function logout()
    {
        // session()->flush();
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('landing');
    }


    public function register(Request $request)
    {
        // Remove leading '+63' or '0'
        if ($request->has('mobile')) {
            $mobile = $request->input('mobile');
            
            // Remove any +63 prefix
            if (substr($mobile, 0, 3) === '+63') {
                $mobile = substr($mobile, 3);
            }
            
            // Ensure it starts with '0'
            if (substr($mobile, 0, 1) !== '0') {
                $mobile = '0' . $mobile;
            }
            
            $request->merge(['mobile' => $mobile]);
        }

        $rules = [
            'first_name'    => ['required', 'string', 'min:2', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'last_name'     => ['required', 'string', 'min:2', 'max:50', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'mobile'        => ['required', 'regex:/^09\d{9}$/', Rule::unique('users', 'mobile')],
            'password'      => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/[a-z]/', // at least one lowercase letter
                'regex:/[A-Z]/', // at least one uppercase letter
                'regex:/[0-9]/', // at least one number
                'confirmed'      // password_confirmation must match
            ],
            'password_confirmation' => ['required'],
            // 'terms'         => ['accepted']
        ];

        $messages = [
            'first_name.required'            => 'The first name field is required.',
            'first_name.min'                 => 'The first name must be at least 2 characters.',
            'first_name.max'                 => 'The first name may not be greater than 50 characters.',
            'first_name.regex'               => 'The first name must contain only letters and spaces.',
            'last_name.required'             => 'The last name field is required.',
            'last_name.min'                  => 'The last name must be at least 2 characters.',
            'last_name.max'                  => 'The last name may not be greater than 50 characters.',
            'last_name.regex'                => 'The last name must start with an uppercase letter and contain only letters and spaces.',
            'email.required'                 => 'The email field is required.',
            'email.email'                    => 'Please enter a valid email address.',
            'email.unique'                   => 'This email is already registered.',
            'email.regex'                    => 'Please enter a valid email address with a standard domain (e.g., .com, .net, .org).',
            'mobile.required'                => 'The mobile field is required.',
            'mobile.regex'                   => 'The mobile number must be a valid Philippine number in format 09XXXXXXXXX.',
            'mobile.unique'                  => 'This mobile number is already registered.',
            'password.required'              => 'The password field is required.',
            'password.min'                   => 'The password must be at least 8 characters.',
            'password.max'                   => 'The password may not be greater than 16 characters.',
            'password.regex'                 => 'The password must contain at least one lowercase letter, one uppercase letter, and one number.',
            'password.confirmed'             => 'The password does not match.',
            'password_confirmation.required' => 'The confirm password field is required.'
            // 'terms.accepted'                 => 'You must accept the terms and conditions to proceed.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request) {
            if ($request->input('password') !== $request->input('password_confirmation')) {
                //  error sa 2 pw
                $validator->errors()->add('password', 'The password does not match.');
                $validator->errors()->add('password_confirmation', 'The password does not match.');
            }
        });

        $credentials = $validator->validate();
        unset($credentials['password_confirmation']);

        $credentials['password'] = bcrypt($credentials['password']); // Hash
        $user = User::create($credentials); // Create

        auth()->guard('web')->login($user); //LOGIN THE USER
        
        //send verification email
        $code = mt_rand(100000, 999999);
        DB::table('users')->where('id', $user->id)->update([
            'verification_code' => $code
        ]);

        Mail::send('emails.verify-code', ['code' => $code], function ($message) use ($user) {
            $message->to($user->email)
                ->subject('Your Email Verification Code');
        });

        // Redirect to the verification notice page
        return redirect()->route('verification.notice');
        // session()->flash('success', 'Account created successfully. Please log in.');
        // return redirect()->route('login');
    }
    // public function verifyNotice()
    // {
    //     return view('auth.verify-email');
    // }
    // public function verifyEmail(Request $request, $id, $hash)
    // {
    //     $user = User::findOrFail($id);

    //     if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
    //         abort(403, 'Invalid verification link.');
    //     }

    //     if ($user->hasVerifiedEmail()) {
    //         return redirect()->route('login')->with('message', 'Email already verified.');
    //     }

    //     $user->markEmailAsVerified();
    //     event(new Verified($user));

    //     return redirect()->route('login')->with('message', 'Email successfully verified! You can now log in.');
    // }
    // public function verifyHandler(Request $request)
    // {
    //     $request->user()->sendEmailVerificationNotification();

    //     return back()->with('message', 'Verification link sent!');
    // }
    public function update(Request $request, User $user)
    {
        // Validate the incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed', // Password is optional
            'role' => 'required|string|in:admin,customer',
        ]);

        // Update user details
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password, // Keep old password if not changed
            'role' => $request->role,
        ]);

        // Redirect to users index with success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect to users index with success message
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
