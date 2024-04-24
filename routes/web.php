<?php


use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\RunningCostsController;
use App\Http\Controllers\CustomerQuotesController;
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
    return view('home');
});

Auth::routes();

Route::get('/home', [StaticPagesController::class, 'home'])->name('home');




// Back-end routes

// Admin routes
Route::group(['middleware' => ['auth', 'role:admin', 'permission:view admin dashboard']], function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.index');

});



// Services routes
Route::group(['middleware' => ['auth', 'role:admin|manager', 'permission:manage services']], function () {
    Route::get('/services', [ServicesController::class, 'index'])->name('services.index');

    Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');

    Route::post('/services', [ServicesController::class, 'store'])->name('services.store');

    Route::get('/services/{service}/edit', [ServicesController::class, 'edit'])->name('services.edit');

    Route::put('/services/{service}/update', [ServicesController::class, 'update'])->name('services.update');

    Route::delete('/services/{service}/delete', [ServicesController::class, 'destroy'])->name('services.destroy');
});


// Quotes routes
Route::group(['middleware' => ['auth', 'role:admin|manager', 'permission:manage quotes']], function () {
    Route::get('/quotes', [QuotesController::class, 'index'])->name('quotes.index');

    

    Route::put('/quotes/{quote}/accept', [QuotesController::class, 'accept'])->name('quotes.accept');

    Route::delete('quotes/{quote}/delete', [QuotesController::class, 'destroy'])->name('quotes.destroy');

    Route::get('/quotes/{id}/edit', [QuotesController::class, 'edit'])->name('quotes.edit');

    Route::put('/quotes/{id}', [QuotesController::class, 'update'])->name('quotes.update');
});
Route::post('/quotes', [QuotesController::class, 'store'])->middleware(['permission:create quotes'])->name('quotes.store');
Route::get('/quotes/create', [QuotesController::class, 'create'])->middleware(['permission:create quotes'])->name('quotes.create');


// Employee Routes
Route::group(['middleware' => ['auth', 'role:admin|manager', 'permission:manage employees']], function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');

    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

    Route::delete('/employees/{employee}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');
});


// Running Costs Routes
Route::group(['middleware' => ['auth', 'role:admin|manager', 'permission:manage running costs']], function () {

});
Route::get('/runningcosts', [RunningCostsController::class, 'index'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.index');

Route::get('/runningcosts/create', [RunningCostsController::class, 'create'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.create');

Route::post('/runningcosts', [RunningCostsController::class, 'store'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.store');

Route::put('/runningcosts/{runningcost}/edit', [RunningCostsController::class, 'edit'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.edit');

Route::put('/runningcosts/{runningcost}', [RunningCostsController::class, 'update'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.update');

Route::delete('/runningcosts/{runningcost}/delete', [RunningCostsController::class, 'destroy'])->middleware(['auth', 'role:admin|manager'])->name('runningcosts.destroy');

// Projects Routes
Route::group(['middleware' => ['auth', 'role:admin|manager', 'permission:manage projects']], function () {
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');

    Route::get('/projects/{quote}/create', [ProjectsController::class, 'create'])->name('projects.create');
    
    Route::post('/projects', [ProjectsController::class, 'store'])->name('projects.store');
    
    Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
    
    Route::put('/projects/{project}', [ProjectsController::class, 'update'])->name('projects.update');
    
    Route::put('/projects/{project}/completed', [ProjectsController::class, 'complete'])->name('projects.complete');
    
    Route::delete('/projects/{project}/delete', [ProjectsController::class, 'destroy'])->name('projects.destroy');
});


// Users routes
Route::group(['middleware' => ['auth', 'role:admin', 'permission:manage users']], function () {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    
    Route::delete('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.destroy');
});


// Roles routes
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/roles/create', [RolesController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolesController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RolesController::class, 'destroy'])->name('roles.destroy');
});

// Managers routes
Route::group(['middleware' => ['auth', 'role:manager', 'permission:view manager dashboard']], function () {
    Route::get('/dashboard/manager', [ManagerController::class, 'index'])->name('manager.index');
});

Route::group(['middleware' => ['auth', 'role:customer', 'permission:view customer dashboard']], function () {
    Route::get('/dashboard/customer', [CustomerController::class, 'index'])->name('customer.index');
    
});
