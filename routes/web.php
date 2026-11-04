<?php

use App\Http\Controllers\OlympicGameController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/olympic-games');
Route::resource('olympic-games', OlympicGameController::class);
