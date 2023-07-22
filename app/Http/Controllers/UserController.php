<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function showProfile()
    {
        // Assuming you have an authenticated user, you can retrieve their data like this:
        $user = User::find(auth()->user()->id);

        return view('user.profile', ['user' => $user]);
    }
}
