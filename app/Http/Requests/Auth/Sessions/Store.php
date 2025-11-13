<?php

namespace App\Http\Requests\Auth\Sessions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class Store extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'=>['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function attributes() 
    {
        return [
            'email' => 'Почта',
            'password' => 'Пароль',
        ];

    }

    public function tryAuthUser()
    {
        
        $credentials = $this->only(['email', 'password']);
        $remember = $this->boolean('remember');

        if(!Auth::attempt($credentials, $remember)){
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        /* if (!Auth::attempt($this->only(['email', 'password']), $this->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        } */
    }
}
