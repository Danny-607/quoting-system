<?php


use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\RunningCostsController;
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

// Admin routes
Route::get('/dashboard/admin', [AdminController::class, 'index'])->middleware(['auth','role:admin'])->name('admin.index');

Route::get('/services/admin', [AdminController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('admin.index');


// Services routes
Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

Route::get('/services/create', [ServicesController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('services.create');

Route::post('/services', [ServicesController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('services.store');

Route::get('/services/{service}/edit', [ServicesController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('services.edit');

Route::put('/services/{service}/update', [ServicesController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('services.update');

Route::delete('/services/{service}/delete', [ServicesController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('services.destroy');

// Quotes routes

Route::get('/quotes', [QuotesController::class, 'index'])->name('quotes.index');

Route::get('/quotes/create', [QuotesController::class, 'create'])->name('quotes.create');

Route::post('/quotes', [QuotesController::class, 'store'])->name('quotes.store');

Route::put('/quotes/{quote}/accept', [QuotesController::class, 'accept'])->middleware(['auth', 'role:admin|manager'])->name('quotes.accept');

Route::delete('quotes/{quote}/delete', [QuotesController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('quotes.destroy');

// Employee Routes

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

Route::delete('/employees/{employee}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');

// Running Costs Routes
Route::get('/runningcosts', [RunningCostsController::class, 'index'])->name('runningcosts.index');

Route::get('/runningcosts/create', [RunningCostsController::class, 'create'])->name('runningcosts.create');

Route::post('/runningcosts', [RunningCostsController::class, 'store'])->name('runningcosts.store');

Route::put('/runningcosts/{runningcost}/edit', [RunningCostsController::class, 'edit'])->name('runningcosts.edit');

Route::put('/runningcosts/{runningcost}', [RunningCostsController::class, 'update'])->name('runningcosts.update');

Route::delete('/runningcosts/{runningcost}/delete', [RunningCostsController::class, 'destroy'])->name('runningcosts.destroy');

// Projects Routes
Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');

Route::get('/projects/{quote}/create', [ProjectsController::class, 'create'])->name('projects.create')->middleware('auth');

Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
