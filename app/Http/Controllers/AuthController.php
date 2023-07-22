<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
        ]);

        $loginData = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        if (Auth::attempt($loginData)) {
            if (Auth::user()->role == 'admin') {
                return redirect('manage');
            } elseif (Auth::user()->role == 'user') {
                return redirect('');
            }
        } else {
            return redirect('')->withErrors("Email or Password is incorrect")->withInput();
        }
    }

    function logout() {
        Auth::logout();
        return redirect('login');
    }
}