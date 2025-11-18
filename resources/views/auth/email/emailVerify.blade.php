@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 500px; margin: auto; padding: 2rem; border: 1px solid #ddd; border-radius: 5px;">
    <h2>Подтвердите вашу почту</h2>
    <p>Перед продолжением, пожалуйста, проверьте свою почту и перейдите по ссылке для подтверждения.</p>
    <p>Если письмо не пришло, вы можете запросить отправку повторно.</p>

    @if (session('message'))
        <div style="background-color: #d4edda; padding: 10px; border-radius: 5px; color: #155724; margin-bottom: 15px;">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border:none; border-radius: 3px; cursor: pointer;">
            Отправить письмо повторно
        </button>
    </form>
</div>
@endsection