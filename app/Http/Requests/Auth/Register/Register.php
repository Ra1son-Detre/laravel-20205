<?php

namespace App\Http\Requests\Auth\Register;

use Illuminate\Foundation\Http\FormRequest;

class Register extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    public function attributes() 
    {
        return [
            'name' => 'Имя',
            'email' => 'Почта',
            'password' => 'Пароль',
            
        ];

    }
   
    public function rules()
    {
        return [
        'name' => ['required', 'string', 'min:2', 'max:32'],
        'email' =>['required', 'email', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
        ];
    }
}
