<?php


use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\ManagerController;
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

// Back-end routes

// Admin routes
Route::get('/dashboard/admin', [AdminController::class, 'index'])->middleware(['auth','role:admin'])->name('admin.index');

Route::get('/services/admin', [AdminController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('admin.index');


// Services routes
Route::get('/services', [ServicesController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('services.index');

Route::get('/services/create', [ServicesController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('services.create');

Route::post('/services', [ServicesController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('services.store');

Route::get('/services/{service}/edit', [ServicesController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('services.edit');

Route::put('/services/{service}/update', [ServicesController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('services.update');

Route::delete('/services/{service}/delete', [ServicesController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('services.destroy');

// Quotes routes

Route::get('/quotes', [QuotesController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('quotes.index');

Route::get('/quotes/create', [QuotesController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('quotes.create');

Route::post('/quotes', [QuotesController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('quotes.store');

Route::put('/quotes/{quote}/accept', [QuotesController::class, 'accept'])->middleware(['auth', 'role:admin|manager'])->name('quotes.accept');

Route::delete('quotes/{quote}/delete', [QuotesController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('quotes.destroy');

Route::get('/quotes/{id}/edit', [QuotesController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('quotes.edit');

Route::put('/quotes/{id}', [QuotesController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('quotes.update');


// Employee Routes

Route::get('/employees', [EmployeeController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('employees.index');

Route::get('/employees/create', [EmployeeController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('employees.create');

Route::post('/employees', [EmployeeController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('employees.store');

Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('employees.edit');

Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('employees.update');

Route::delete('/employees/{employee}/delete', [EmployeeController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('employees.destroy');

// Running Costs Routes
Route::get('/runningcosts', [RunningCostsController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.index');

Route::get('/runningcosts/create', [RunningCostsController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.create');

Route::post('/runningcosts', [RunningCostsController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.store');

Route::put('/runningcosts/{runningcost}/edit', [RunningCostsController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.edit');

Route::put('/runningcosts/{runningcost}', [RunningCostsController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.update');

Route::delete('/runningcosts/{runningcost}/delete', [RunningCostsController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.destroy');

// Projects Routes
Route::get('/projects', [ProjectsController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('projects.index');

Route::get('/projects/{quote}/create', [ProjectsController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('projects.create');

Route::post('/projects', [ProjectsController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('projects.store');

Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('projects.edit');

Route::put('/projects/{project}', [ProjectsController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('projects.update');

Route::put('/projects/{project}/completed', [ProjectsController::class, 'complete'])->middleware(['auth', 'role:admin|manager'])->name('projects.complete');

// Managers routes
Route::get('/dashboard/manager', [ManagerController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('manager.index');
