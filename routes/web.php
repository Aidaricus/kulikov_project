<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CreateUserController;
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
    // if (auth()->user()) {
    //     auth()->user()->assignRole('user');
    // }
    return view('welcome');
});

Route::get('/dashboard', function () {
    $authorized_user = Auth::user();
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// // CRUD
Route::resource('users', CreateUserController::class)->middleware('auth');

Route::resource('products', ProductController::class)->middleware('auth');

Route::resource('categories', CategoryController::class)->middleware('auth');

require __DIR__ . '/auth.php';
