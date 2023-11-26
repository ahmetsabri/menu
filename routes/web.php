<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::group(['prefix' => 'restaurants'], function () {

        Route::prefix('{restaurant}/categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('category.index')->withoutMiddleware('auth');
            Route::get('/{category}', [CategoryController::class, 'show'])
            ->name('category.show')->withoutMiddleware('auth');
            Route::post('/', [CategoryController::class, 'store'])->name('category.store');
            Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('{category}', [CategoryController::class, 'update'])->name('category.update');
            Route::delete('{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

            Route::prefix('{category}/items')->group(function () {
                Route::get('/', [ItemController::class, 'index'])->name('item.index');
                Route::get('/create', [ItemController::class, 'create'])->name('item.create');
                Route::post('/', [ItemController::class, 'store'])->name('item.store');
                Route::get('{item}/edit', [ItemController::class, 'edit'])->name('item.edit');
                Route::post('{item}', [ItemController::class, 'update'])->name('item.update');
                Route::delete('{item}', [ItemController::class, 'destroy'])->name('item.destroy');
            });
        });


        Route::get('/', [RestaurantController::class, 'index'])->name('restaurant.index');
        Route::view('/create', 'restaurants.create')->name('restaurant.create');
        Route::get('{restaurant}', [RestaurantController::class, 'show'])
        ->name('restaurant.show')->withoutMiddleware('auth');
        Route::get('{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurant.edit');
        Route::post('/', [RestaurantController::class, 'store'])->name('restaurant.store');
        Route::post('{restaurant}', [RestaurantController::class, 'update'])->name('restaurant.update');
        Route::delete('{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurant.destroy');
    });
});

require __DIR__ . '/auth.php';
