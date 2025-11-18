<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\Register\Register;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register.create');
    }

    public function store(Register $request)
    {
        $user = User::create($request->validated());
        event(new Registered($user));
        Auth::login($user);
       
        return redirect()->route('cars.showAll')
        ->with('success', 'Вы успешно зарегестрированы! Подтвердите почту. ');
    }
}
