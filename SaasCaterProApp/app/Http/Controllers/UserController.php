<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $loginInfo = $request->validate([
            'loginemail' => ['required', 'email'], //email format
            'loginpassword' => ['required', 'string', 'min:8']
        ], [
            'loginemail.required' => 'The email field is required.',
            'loginemail.email' => 'Please enter a valid email address.',
            'loginpassword.required' => 'The password field is required.',
            'loginpassword.min' => 'The password must be at least 8 characters.'
        ]);
        //check nya if yung email nage-exist sa database
        $user = User::where('email', $loginInfo['loginemail'])->first();

        if (!$user) {
            // If wla email
            return back()->withErrors([
                'loginemail' => 'email does not exist',
            ])->onlyInput('loginemail');
        }

        if (Auth::attempt(['email' => $loginInfo['loginemail'], 'password' => $loginInfo['loginpassword']])) {
            $request->session()->regenerate();

            return redirect('/home')->with('success', 'Login successful!');
        }
        // pag mali pass 
        return back()->withErrors([
            'loginpassword' => 'password is incorrect.',
        ])->onlyInput('loginemail');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect("/");
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'first_name' => ['required', 'string', 'min:4', 'max:50'],
            'last_name'  => ['required', 'string', 'min:2', 'max:50'],
            'email'     => ['required', 'email', Rule::unique('users', 'email')],
            'mobile'    => ['required', 'digits_between:10,15', Rule::unique('users', 'mobile')],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'confirmed'
            ],
            [
                'first_name.required' => 'The first name field is required.',
                'first_name.min' => 'The first name must be at least 4 characters.',
                'first_name.max' => 'The first name may not be greater than 50 characters.',
                'last_name.required' => 'The last name field is required.',
                'last_name.min' => 'The last name must be at least 2 characters.',
                'last_name.max' => 'The last name may not be greater than 50 characters.',
                'email.required' => 'The email field is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already registered.',
                'mobile.required' => 'The mobile field is required.',
                'mobile.digits_between' => 'The mobile number must be between 10 and 15 digits.',
                'mobile.unique' => 'This mobile number is already registered.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 8 characters.',
                'password.max' => 'The password may not be greater than 16 characters.',
                'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, and one number.'
            ]
        ]);

        $credentials['password'] = bcrypt($credentials['password']); //built in rin ng laravel yung bcrypt to hash
        $user = User::create($credentials); //yung user is built-in ng laravel

        // Auth::login($user); hayaan mo lng to optional lng to para ilogin agad
        // Gawin ko muna papunta sa home - Marjouk
        return redirect('/home');
    }
}
