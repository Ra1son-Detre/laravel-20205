<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Sessions\Store as LoginRequest;
use App\Providers\RouteServiceProvider;

class SessionsController extends Controller
{
    public function create()
    {
        return view('auth.sessions.create');
    }

    public function store(LoginRequest $request)
    {
        $request->tryAuthUser();
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME); //intended это тот адрес на котоырй пытались зайти, и он запоминается 
    }
}
