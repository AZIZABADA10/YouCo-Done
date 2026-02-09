<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HoraireController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('restaurants.index');
});

Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');



Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('favoris')->name('favoris.')->group(function () {
        Route::get('/', [FavoriController::class, 'index'])->name('index');
        Route::post('/restaurants/{restaurant}', [FavoriController::class, 'store'])->name('store');
        Route::delete('/restaurants/{restaurant}', [FavoriController::class, 'destroy'])->name('destroy');
    });

    Route::middleware(['role:restaurateur|admin'])->group(function () {
        Route::get('/my-restaurants', [RestaurantController::class, 'myRestaurants'])->name('restaurants.my');
        Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
        Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
        
        Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
        Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
        Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');

        Route::get('/restaurants/{restaurant}/horaires/edit', [HoraireController::class, 'edit'])->name('horaires.edit');
        Route::put('/restaurants/{restaurant}/horaires', [HoraireController::class, 'update'])->name('horaires.update');

        Route::prefix('restaurants/{restaurant}/menus')->name('menus.')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::get('/create', [MenuController::class, 'create'])->name('create');
            Route::post('/', [MenuController::class, 'store'])->name('store');
            Route::get('/{menu}', [MenuController::class, 'show'])->name('show');
            Route::get('/{menu}/edit', [MenuController::class, 'edit'])->name('edit');
            Route::put('/{menu}', [MenuController::class, 'update'])->name('update');
            Route::delete('/{menu}', [MenuController::class, 'destroy'])->name('destroy');

            Route::prefix('{menu}/plats')->name('plats.')->group(function () {
                Route::get('/create', [PlatController::class, 'create'])->name('create');
                Route::post('/', [PlatController::class, 'store'])->name('store');
                Route::get('/{plat}/edit', [PlatController::class, 'edit'])->name('edit');
                Route::put('/{plat}', [PlatController::class, 'update'])->name('update');
                Route::delete('/{plat}', [PlatController::class, 'destroy'])->name('destroy');
            });
        });
    });


    
    Route::prefix('admin')->name('admin.')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('restaurants');
        Route::delete('/restaurants/{restaurant}', [AdminController::class, 'deleteRestaurant'])->name('restaurants.delete');
    });
});

Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

require __DIR__.'/auth.php';