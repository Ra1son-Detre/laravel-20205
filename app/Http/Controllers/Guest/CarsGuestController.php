<?php

namespace App\Http\Controllers\Guest;

use App\Enum\Cars\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Comments\Store as AddComment;

class CarsGuestController extends Controller
{
    public function index()
    {   
        /* $cars = Car::ofActive()->with('brand.country', 'tags')->orderBy('created_at')->get(); */
        $cars = Car::allExceptUnset()->get(); //тут подготовленный запрос из модели Car
        return view('cars.index',compact('cars'));
        /* dd($cars); */
    }

    
    public function show(Car $car)
    {   
        
        /* dd($car->status->text()); */
        /* $car->load('tags', 'comments'); */ // можно вообще это убрать, в блейде все передается и выводится (магия)
        /* dd($car->comments()->get()->pluck('comment', 'id')); */
        $comment = $car->comments()->get()->pluck('comment', 'id');
        return view('cars.show', compact('car', 'comment'));
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
       ->route('cars.showById', $car->id)
       ->with('success', 'Комментарий успешно добавлен!');
    }

 
    

  
}
