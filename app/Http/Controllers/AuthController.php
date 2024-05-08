<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    function authenticating(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // cek apakah login valid

        if (Auth::attempt($credentials)) {
            // cek apakah user status = active
            if (Auth::user()->status != "active") {

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                Session::flash('status', 'failed');
                Session::flash('message', 'Your account is not active yet. please contact admin!');
                return redirect('/login');
            }


            $request->session()->regenerate();
            if (Auth::user()->role_id == 1) {
                return redirect('dashboard');
            }

            if (Auth::user()->role_id == 2) {
                return redirect('profile');
            }
        }
        Session::flash('status', 'failed');
        Session::flash('message', 'Login invalid');
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:250|unique:users',
            'password' => 'required|min:6|max:250',
            'phone' => 'max:250',
            'address' => 'required',
        ]);

        User::create($request->all());

        Session::flash('status', 'succsess');
        Session::flash('message', 'Register Succsess,Wait admin for approve');
        return redirect('register');
    }
}
