<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\ServicesController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');

Route::post('/services', [ServicesController::class, 'store'])->name('services.store');
