@extends('layouts.appBrend')
@section('title', 'Create brand')
@section('content')

<h2>Create brand</h2>
<form method="post" action="{{route('brands.store')}}">
    @csrf
    
    <x-cars.input label="Марка авто" name="title" />
    <x-form-select 
    class="form-label" 
    name="country_id" 
    label="Страна" 
    :options="$countries" 
    :size="1" 
    placeholder="Не выбрано">
</x-form-select>
    <x-cars.input label="Описание" name="description" />
    <button>Send</button>
</form>
@endsection