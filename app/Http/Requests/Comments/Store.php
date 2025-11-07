<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Store extends FormRequest
{

    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'author' => 'nullable|min:2|max:100',
            'comment' => 'required|min:2|max:1000',
        ];
    }

    public function attributes() 
    {
        return [
            'author' => 'Автор',
            'comment' => 'Комментарий',
        ];

    }
}