<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\GallonOfWaterController;
use Illuminate\Support\Facades\Route;

Route::get('/gallon-of-water', GallonOfWaterController::class)->name('gallon_of_water');

Route::get('/articles', [ArticleController::class, 'list'])->name('articles.list');
Route::post('/articles/uploads', [ArticleController::class, 'import'])->name('articles.import');
