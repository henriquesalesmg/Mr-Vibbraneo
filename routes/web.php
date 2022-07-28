<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{TaskController, SubTaskController, OperationController, UserController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return redirect()->route('login');
});


Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified'])->group(function () {

    Route::get('dashboard', [OperationController::class, 'dashboard'])->name("dashboard");
    Route::get('about', [OperationController::class, 'about'])->name("about");

    Route::resource('lists', TaskController::class);
    Route::get('status', [OperationController::class, 'status'])->name("status");

    Route::resource('sublist', SubTaskController::class);
    Route::get('sublists/{id}', [OperationController::class, 'list'])->name("sublists");
    Route::get('sublists-create/{id}', [OperationController::class, 'new'])->name("sublists-create");
    Route::get('sublists-remove/{id}', [OperationController::class, 'remove'])->name("sublists-remove");


    Route::resource('users', UserController::class)->middleware('level:1');
});
