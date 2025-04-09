<?php
namespace App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConcessionController;
use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Middleware\SetLocale;

Route::get('/', function () {
    return redirect()->route('login');
});

    Route::get('/dashboard', function () {
        return redirect()->route('concessions.index');
    })->middleware(['auth', 'verified'])->name('dashboard');


    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    Route::middleware('auth')->group(function () {
        
        Route::resource('concessions', ConcessionController::class);
        Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::post('/orders/{order}/send-to-kitchen', [OrderController::class, 'sendToKitchen'])->name('orders.sendToKitchen');

        Route::resource('kitchen', KitchenController::class);
        Route::post('/kitchen/{order}/complete', [KitchenController::class, 'completeOrder'])->name('kitchen.completeOrder');
        

    });



require __DIR__.'/auth.php';
