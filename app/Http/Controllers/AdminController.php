<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    function index()
    {
        return view('manage.index');
    }

    function transaction()
    {
        return view('manage.transaction');
    }

    function product()
    {
        return view('manage.product');
    }
}
