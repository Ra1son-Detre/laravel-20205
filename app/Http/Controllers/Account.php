<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Account extends Controller
{
    public function index()
    {   
        $user = Auth::user();
        return view('account.index', compact('user'));
    }
}
