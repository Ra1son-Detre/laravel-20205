@extends('layouts.app')

@section('title', 'Регистрация')

@section('content')

<h1 class="mb-4">Регистрация</h1>

<form action="{{ route('auth.register.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Имя</label>
        <input type="text"
               name="name"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Почта</label>
        <input type="email"
               name="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Повторите пароль</label>
        <input type="password"
               name="password_confirmation"
               class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
</form>

@endsection