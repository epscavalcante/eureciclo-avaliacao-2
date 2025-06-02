<?php

use App\Http\Controllers\GallonOfWaterController;
use Illuminate\Support\Facades\Route;

Route::get('/gallon-of-watter', GallonOfWaterController::class)->name('gallon_of_water');
