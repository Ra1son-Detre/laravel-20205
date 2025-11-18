<?php

use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Posts;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\Guest\CarsGuestController;
use Illuminate\Routing\RouteRegistrar;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::prefix('/auth')->group(function(){
    Route::controller(SessionsController::class)->group(function(){
        Route::get('/login', 'create')->name('auth.session.create');
        Route::post('/login', 'store')->name('auth.session.store');
    });
});

Route::prefix('/auth')->group(function(){
    Route::controller(RegisterController::class)->group(function(){
        Route::get('/register', 'create')->name('auth.register.create');
        Route::post('/register', 'store')->name('auth.register.store');
    });
});

Route::post('/logout', [LogoutController::class, 'store'])->name('logout'); 

Route::middleware('auth')->group(function () {
    // Страница с просьбой подтвердить email
    Route::get('/email/verify', function () {
        return view('auth.email.emailVerify'); // твой файл emailVerify.blade.php
    })->name('verification.notice');

    // Обработка клика по ссылке из письма (ссылка для подтверждения)
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('cars'); // куда хочешь после подтверждения
    })->middleware(['signed'])->name('verification.verify');

    // Повторная отправка письма с подтверждением
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Ссылка для подтверждения отправлена повторно!');
    })->name('verification.send');
});

Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function(){
Route::get('/cars', [CarsController::class, 'index'])->name('admin.cars.showAll'); //вывод на главную всех машин
Route::get('/cars/create', [CarsController::class, 'create'])->name('admin.cars.create'); //Переход на страничку создания
Route::post('/cars', [CarsController::class, 'store'])->name('admin.cars.store'); //Создание новой сущности (просто записи) в базе
Route::post('/cars/{car}/comment', [CarsController::class, 'addComment'])->name('admin.cars.addComment'); //Добавление комментария к машине 
Route::get('/cars/trash', [CarsController::class, 'showTrashCars'])->name('admin.cars.showTrashCars'); //Показ удаленных машин
Route::put('/cars/{car}/restore', [CarsController::class, 'restore'])->name('admin.cars.restore'); //Восстановление 1 машины
Route::patch('/cars/{car}', [CarsController::class, 'update'])->name('admin.cars.update'); //Редактирование 1 записи
Route::get('/cars/{car}/redaction', [CarsController::class, 'admin.redactionById'])->name('admin.cars.redactionById'); //Дубль над чем работаем 
Route::get('/cars/{car}', [CarsController::class, 'show'])->name('admin.cars.showById');
Route::delete('/cars/{id}/destroyForever', [CarsController::class, 'destroyForever'])->name('admin.cars.destroyForever'); //Окончательное удаление 1 машины
Route::delete('/cars/{car}', [CarsController::class, 'destroy'])->name('admin.cars.delete');
});

Route::prefix('cars')->middleware(['auth', 'verified'])->group(function(){
    Route::controller(CarsGuestController::class)->group(function(){
        Route::get('/', 'index')->name('cars.showAll');
        Route::get('/{car}', 'show')->name('cars.showById');
        Route::post('/{car}/comment', 'addComment')->name('cars.addComment');
    });
});


Route::get('/brands/{brand}/description',[BrandsController::class, 'brandDescription'])->name('brands.brandDescription');
Route::post('/brands/{brand}/comment',[BrandsController::class, 'addComment'])->name('brands.addComment');
Route::resource('brands', BrandsController::class);






/* Route::get('/posts', [Posts::class, 'index'])->name('posts.showAll');
Route::get('/posts/create', [Posts::class, 'create']);
Route::get('/posts/{id}', [Posts::class, 'show'])->name('posts.show');
Route::get('/posts/{id}/edit', [Posts::class, 'edit']);
Route::post('/posts', [Posts::class, 'store'])->name('posts.store');
Route::put('/posts/{id}', [Posts::class, 'update'])->name('posts.update'); */
