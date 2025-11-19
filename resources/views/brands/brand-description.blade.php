@extends('layouts.appBrend')
@section('title', 'description brand')
@section('content')

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0">{{ $brand->title }}</h2>
            <a href="{{ route('admin.brands.index') }}" class="btn btn-light btn-sm">
                ⬅️ Back to all brands
            </a>
        </div>

        <div class="card-body p-4">
            @if($brand->description)
                <p class="fs-5 text-secondary" style="line-height: 1.7;">
                    {{ $brand->description }}
                </p>
            @else
                <p class="text-muted fst-italic">
                    Описание пока не добавлено.
                </p>
            @endif
        </div>
        
        

        <div class="card-footer bg-light text-end">
            <a href="{{ route('admin.brands.show', $brand->id) }}" class="btn btn-outline-primary">
                🔍 Показать все модели этого бренда
            </a>
        </div>
    </div>
</div>
<form method="post" action="{{route('admin.brands.addComment', $brand->id)}}">
        @csrf
        <br>
       <h3> Комментарий к бренду:</h3>
        <x-cars.input label="Имя" name="author" placeholder="Не обязательно" />
        <x-cars.input label="Комментарий" name="comment"  placeholder="Напишите что-нибудь" />
        <button>Send</button>
    </form>
    <x-comment-show :model="$brand" title="Комментарии:" ></x-comment-show>
@endsection

