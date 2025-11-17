<?php

namespace App\Http\Controllers;

use App\Enum\Cars\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Requests\Cars\Save as SaveRequest;
use App\Models\Brand;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Comments\Store as AddComment;

class CarsController extends Controller
{
    public function index()
    {   
        /* $cars = Car::ofActive()->with('brand.country', 'tags')->orderBy('created_at')->get(); */
        $cars = Car::allExceptUnset()->get(); //тут подготовленный запрос из модели Car
        return view('cars.index',compact('cars'));
        /* dd($cars); */
    }

    
    public function create(Car $car)
    {
        $brands = Brand::orderBy('title')->pluck('title', 'id');// pluck делает массив двухмерным вторым параметром ключь 
        $tags = Tag::orderBy('title')->pluck('title', 'id');
        $status = Status::cases();
        return view('cars.create', compact('brands', 'tags', 'status'));
    }

    
    public function store(SaveRequest $request) //todo добить запись enum в таблицу (не понимаю логику)     
    {           
        /* dd($request->validated()); */ 
        $data = collect($request->validated()); //Валидацию превращаем в лара коллекцию
        
        $car = Car::make($data->except('tags')->toArray()); //Исключаем отсюда таги, после чего превращаем в массив т.к модель приним массив а не коллекцию 
        
        DB::transaction(function() use (& $data, & $car){
        $car->save(); //Сохраняем модель car в базу
        $car->tags()->sync($data->get('tags')); // Привязываем теги к машине через связь many-to-many 
        });

        return redirect()->route('admin.cars.showAll')->with('success', __('alerts.cars.store', ['brand' => $car->brand->title, 'model' => $car->model])); // выводится весь объект Eloquent стоит быть внимательным при выводе 
    }
   
    public function show(Car $car)
    {   
        
        /* dd($car->status->text()); */
        /* $car->load('tags', 'comments'); */ // можно вообще это убрать, в блейде все передается и выводится (магия)
        /* dd($car->comments()->get()->pluck('comment', 'id')); */
        $comment = $car->comments()->get()->pluck('comment', 'id');
        return view('cars.show', compact('car', 'comment'));
    }

   
    public function edit($id)
    {
        //
    }

  
    public function update(SaveRequest $request, Car $car) //todo пофиксить и разобраться какого хуя не рабоатет с SaveReauest покопаться в Put и patch
    {
       
       $oldModel = $car->model;
       $data = collect($request->validated());
       $car->update($data->except(['tags'])->toArray()); 
       $car->tags()->sync($data->get('tags', []));
       
       
       return redirect('/cars')->with('success', __ ('alerts.cars.update',['oldModel' => $oldModel]));// 
    }

 
    public function destroy(Car $car) // Динамический атрибут canDelete который описан в модели Car
    {   
        if($car->canDelete) {
        $car->delete();
        return redirect()->route('admin.cars.showAll')->with('success', __ ('alerts.cars.destroy', ['brand' => $car->brand, 'model' => $car->model]));
        } else {
            return  redirect()->route('admin.cars.showById', ['car' => $car])->with('success', __('alerts.cars.errStatusDel' ));
        }
    }

        
    public function addComment(AddComment $request, Car $car)
    {
       $validated = $request->validated();
       /* $car->comments()->create([
        'comment' => $validated['comment'],
        'author' => $validated['author'] ?? 'Гость',
       ]); */
       $car->comments()->create($validated);

       return redirect()
       ->route('admin.cars.showById', $car->id)
       ->with('success', 'Комментарий успешно добавлен!');
    }

    public function redactionById(Car $car) // todo по хорошему перенести в едит это все но потом на свежую голову 
    {
        $transmissions = config('app-cars.transmissions');
        $tags = Tag::orderBy('title')->pluck('title', 'id');
        $brands = Brand::orderBy('title')->pluck('title', 'id');
        return view('cars.redaction', compact('car', 'brands', 'tags', 'transmissions'));
    }

    public function showTrashCars()
    {
        $trashCars = Car::onlyTrashed()->orderByDesc('created_at')->get(); // ТОЛЬКО удаленные записи после мягкого удаления
        return view('cars.trash' , compact('trashCars'));
    }

    public function restore ($id)
    {
       $trashCar = Car::onlyTrashed()->findOrFail($id);

        // Для случае если запись уже удалена из базы надо использовать try catch 

        $trashCar->restore();

        return redirect()->route('admin.cars.showAll')->with('success', __('alerts.cars.restore', ['brand' => $trashCar->brand->title, 'model' => $trashCar->model]));
    }

    public function destroyForever ($id) 
    {   
        $car = Car::withTrashed()->findOrFail($id);
        $car->forceDelete();

        return redirect()->route('admin.cars.showTrashCars')->with('success', __('alerts.cars.destroyForever', ['brand'=> $car->brand, 'model'=>$car->model->title]));
    }

}
