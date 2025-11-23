<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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

    public function checkCommentable()
    {
        $commentable = config('commentable');
        if(!isset($commentable[$this->model])){
            Log::alert('Кто-то пытается изменить имя модели или ip');
            
            throw ValidationException::withMessages([
                'model' => 'wrong model'
            ]);
        }
        $this->$commentable[$this->model]::findOrFail($this->id);
    }
}