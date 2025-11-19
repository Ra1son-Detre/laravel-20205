@extends('layouts.app')

@section('title', 'Trashs Cars')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


@if($trashCars->isNotEmpty())
<h1 class="mb-4">Trash Cars</h1>



<div class="list-group">
    @foreach($trashCars as $car)
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <strong>Brand:</strong> {{ $car->brand->title }}<br>
                <strong>Model:</strong> {{ $car->model }}<br>
                <strong>Transmission:</strong> {{ $car->transmission }}<br>
                <strong>Vin:</strong> {{ $car->vin }}<br>
                <strong>Price:</strong> ${{ $car->price }}
            </div>
            <div class="d-flex gap-2">
                <form action="{{route('admin.cars.restore', $car->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-warning btn-sm" type="submit">Restore</button>
                </form>

                <form action="{{route('admin.cars.destroyForever', $car->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this car?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" type="submit">Delete Permanently</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@else
<p><em>There are no deleted machines yet.</em></p>
@endif
@endsection
