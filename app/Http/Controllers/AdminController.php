<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {
        return view('manage.index');
    }

    function dashboard()
    {
        return view('manage.dashboard');
    }

    function product()
    {
        return view('manage.product');
    }
}
