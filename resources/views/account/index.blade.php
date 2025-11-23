@extends('layouts.app')

@section('title', 'Your Profile')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">
            👤 {{ $user->name }} — Профиль
        </h3>
    </div>
    <br><h2>Детали пользователя:</h2><br>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Имя:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>ID:</strong> {{ $user->id }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Дата регистрации:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Последнее обновление:</strong> {{ $user->updated_at->format('d.m.Y H:i') }}</p>
                <p><strong>Действия:</strong></p>
                <a href="{{ route('cars.showAll') }}" class="btn btn-primary btn-sm">Список машин</a>
                <a href="{{ route('logout') }}"
                   class="btn btn-danger btn-sm"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

@endsection