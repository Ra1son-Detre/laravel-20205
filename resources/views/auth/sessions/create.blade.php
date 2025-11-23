@extends('layouts.app')
@section('title', 'Create user')
@section('content')
@if(!auth()->user()) {{-- //todo Тут по хорошему запретить повторный вход на логин через мидлвары, не надо браться с головой --}}
<form method="post" action="{{route('auth.session.store')}}">
@csrf
<x-form-input name="email" label="Почта" placeholder="Введите почту."></x-form-input>
<x-form-input name="password" label="Пароль" type="password" placeholder="Введите пароль."></x-form-input><br>
<x-form-checkbox name="remember" label="Запомнить меня!" ></x-form-checkbox>
<button class="btn btn-success">Войти</button>
</form>
@endif
@endsection