<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;

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
    return redirect()->route('login');
});

// ROUTE AUTENTIKASI (Tanpa login)
Route::get('backend/login', [AuthController::class, 'login'])->name('login'); // menampilkan halaman login
Route::post('backend/login', [AuthController::class, 'loginAction'])->name('loginAction'); // proses login
Route::post('backend/logout', [AuthController::class, 'logout'])->name('logout'); // proses logout

Route::get('backend/register', [AuthController::class, 'register'])->name('register'); // menampilkan halaman register 
Route::post('backend/register', [AuthController::class, 'registerSave'])->name('registerSave'); // proses register


Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('dashboard', function () {
        return view('backend.dashboard.dashboard');
    })->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('recipes', RecipeController::class);
    Route::resource('reviews', ReviewController::class);
});

Route::middleware('auth', 'role:user')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
});
