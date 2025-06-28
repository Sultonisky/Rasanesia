<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminFavoriteController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use Illuminate\Http\Request;

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

// ROUTE UTAMA - Tanpa autentikasi
Route::get('/', [HomeController::class, 'welcome'])->name('welcome'); // Halaman welcome
Route::get('/main-home', [HomeController::class, 'mainHome'])->name('main-home'); // Halaman utama tanpa login

// ROUTE AUTENTIKASI (Tanpa login)
Route::get('backend/login', [AuthController::class, 'login'])->name('login'); // menampilkan halaman login
Route::post('backend/login', [AuthController::class, 'loginAction'])->name('loginAction'); // proses login
Route::post('backend/logout', [AuthController::class, 'logout'])->name('logout'); // proses logout

Route::get('backend/register', [AuthController::class, 'register'])->name('register'); // menampilkan halaman register 
Route::post('backend/register', [AuthController::class, 'registerSave'])->name('registerSave'); // proses register

// ROUTE FORGOT PASSWORD
Route::get('backend/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request'); // menampilkan halaman forgot password
Route::post('backend/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email'); // kirim email reset password
Route::get('backend/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('password.reset'); // menampilkan halaman reset password
Route::post('backend/reset-password', [AuthController::class, 'updatePassword'])->name('password.update'); // update password baru

// ROUTE FITUR INTERAKTIF - Memerlukan autentikasi
Route::middleware(['require.auth'])->group(function () {
    // Favorite Routes
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites/check', [FavoriteController::class, 'check'])->name('favorites.check');
});

// ROUTE ADMIN - Memerlukan autentikasi admin
Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return view('backend.dashboard.dashboard');
    })->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('recipes', RecipeController::class);
    Route::resource('reviews', ReviewController::class);
    Route::resource('admin-favorites', AdminFavoriteController::class)->names([
        'index' => 'admin.favorites.index',
        'create' => 'admin.favorites.create',
        'store' => 'admin.favorites.store',
        'show' => 'admin.favorites.show',
        'edit' => 'admin.favorites.edit',
        'update' => 'admin.favorites.update',
        'destroy' => 'admin.favorites.destroy',
    ]);
});

// ROUTE USER - Memerlukan autentikasi user
Route::middleware(['auth', 'role:user', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    
    // Frontend Navigation Routes
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/all-recipes', [HomeController::class, 'allRecipes'])->name('all-recipes');
    Route::get('/archive', [HomeController::class, 'archive'])->name('archive');
    
    // Recipe Routes untuk User
    Route::resource('recipes', RecipeController::class)->except(['index', 'show']);
    Route::get('/my-recipes', [RecipeController::class, 'myRecipes'])->name('my-recipes');
    
    // Saved page
    Route::get('/saved', [FavoriteController::class, 'index'])->name('saved');
    
    // Logout route accessible from frontend
    Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout');
});

// Route verifikasi email Laravel
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('login')->with('message', 'Email berhasil diverifikasi! Silakan login.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi telah dikirim ulang!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify-public/{id}/{hash}', function ($id, $hash, Request $request) {
    $user = User::findOrFail($id);
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403);
    }
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('message', 'Email sudah diverifikasi, silakan login.');
    }
    $user->markEmailAsVerified();
    event(new Verified($user));
    return redirect()->route('login')->with('message', 'Email berhasil diverifikasi! Silakan login.');
})->name('verification.verify.public');
