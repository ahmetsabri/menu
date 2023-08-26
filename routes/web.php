<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix'=>'restaurants'],function(){
        Route::get('/',[RestaurantController::class,'index'])->name('restaurant.index');
        Route::view('/create','restaurants.create')->name('restaurant.create');
        Route::get('{restaurant:slug}',[RestaurantController::class,'show'])->name('restaurant.show');
        Route::get('{restaurant}/edit',[RestaurantController::class,'edit'])->name('restaurant.edit');
        Route::post('/',[RestaurantController::class,'store'])->name('restaurant.store');
        Route::put('{restaurant}',[RestaurantController::class,'update'])->name('restaurant.update');
        Route::delete('{restaurant}',[RestaurantController::class,'destroy'])->name('restaurant.destroy');
    });
});

require __DIR__.'/auth.php';
