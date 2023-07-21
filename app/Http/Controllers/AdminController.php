<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\authAkuna;

class AdminController extends Controller
{
    // Method to show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Method to handle the login form submission
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        //$user = Auth::where('username', $credentials['username'])->first();

        if (Auth::guard('web')->attempt($credentials)) {
            // Authentication successful
            return redirect('/manage/dashboard');
        } else {
            // Authentication failed
            return back()->withErrors(['message' => 'Invalid credentials']);
        }
    }

    // Method to handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
