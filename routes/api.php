<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotoController;

Route::get('photos/store', [PhotoController::class, 'storeApi'])->name('store-api');