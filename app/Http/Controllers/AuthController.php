<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    function index()
    {
        return view('auth.login');
    }

    function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
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

    public function createApiToken(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check if the user has the "admin" role
            if ($user->role === 'admin') {
                $token = $user->createToken('api-token')->plainTextToken;
                return response()->json(['token' => $token], 200);
            } else {
                throw ValidationException::withMessages([
                    'role' => ['Unauthorized. Only users with the "admin" role can create API tokens.'],
                ]);
            }
        } else {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    }
}