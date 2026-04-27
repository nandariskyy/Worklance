<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login', ['error' => null]);
    }

    public function register()
    {
        return view('auth.register', ['error' => null]);
    }
}
