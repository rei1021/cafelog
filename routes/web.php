<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GooglePlaceController;
use App\Http\Controllers\WantgoController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/', function () {
    return view('reviews.index');
})->middleware(['auth', 'verified'])->name('index');

Route::get('/reviews/relay', function () {
    return view('reviews.relay');
})->middleware(['auth', 'verified'])->name('relay');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [ReviewController::class, 'index'])->name('index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('store');
    Route::post('/reviews/create', [ReviewController::class, 'create'])->name('create');
    Route::get('/reviews/relay', [ReviewController::class, 'relay'])->name('relay');
    Route::get('/reviews/{review}', [ReviewController::class, 'show'])->name('show');
    Route::post('/reviews/shopShow', [ReviewController::class, 'shopShow'])->name('shopShow');
    Route::post('/reviews/detailShow', [ReviewController::class, 'detailShow'])->name('detailShow');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('update');
    Route::post('/reviews/like', [ReviewController::class, 'like'])->name('review.like');
    Route::delete('/reviews/relay', [ReviewController::class, 'delete'])->name('delete');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('edit');
    
   
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
   Route::get('/search', [GooglePlaceController::class,'search'])->name('place.search');//合っているかわからない
    Route::get('/search/detail', [GooglePlaceController::class,'detailsearch'])->name('place.detailsearch');
    
});

Route::middleware('auth')->group(function () {
    Route::post('/shops/save', [WantgoController::class, 'saveShop'])->name('shops.save');
});

require __DIR__.'/auth.php';
