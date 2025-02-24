<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Domains\DomainController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('forgot-password');
});

Route::middleware(['auth.login'])->group(function () {
    Route::get('/', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::group(['prefix' => 'domains'], function () {
        Route::get('/', [DomainController::class, 'index'])->name('domains.index');
        Route::get('/create', [DomainController::class, 'create'])->name('domains.create');
        Route::post('/store', [DomainController::class, 'store'])->name('domains.store');
        Route::get('/edit/{domain}', [DomainController::class, 'edit'])->name('domains.edit');
        Route::delete('/delete/{domain}', [DomainController::class, 'delete'])->name('domains.destroy');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/update-address', [ProfileController::class, 'updateAddress'])->name('profile.address.update');
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
