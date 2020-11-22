<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('/', [PhotoController::class, 'index'])->name('index');
Route::post('photos/store', [PhotoController::class, 'store'])->name('store');