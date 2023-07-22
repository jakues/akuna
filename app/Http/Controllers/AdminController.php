<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function manage()
    {
        return view('manage.index');
    }

    function product()
    {
        return view('manage.product');
    }
}
