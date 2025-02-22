<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request){
        $loginInfo = $request->validate([
            'loginemail' => 'required',
            'loginpassword' => 'required'
        ]);
        if(Auth::attempt(['email' => $loginInfo['loginemail'], 'password'=> $loginInfo['loginpassword']])){
            $request->session()->regenerate();
        }
        return redirect('/');
    }
    public function logout(){
        Auth::logout();
        return redirect("/");
    }
    public function register(Request $request){
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
                'regex:/[@$!%*?&]/' // At least one special character
                ]
        ]);
        $credentials['password'] =bcrypt($credentials['password']); //built in rin ng laravel yung bcrypt
        $user = User::create($credentials); //yung user is built-in ng laravel

        Auth::login($user);
        return redirect('/');
    }

}
