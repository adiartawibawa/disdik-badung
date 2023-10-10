<?php

use App\Livewire\Pages\Users\DataUser;
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

require __DIR__ . '/auth.php';

Route::middleware(['guest'])->group(function () {
    // Landing Page
    Route::view('/', 'welcome')->name('welcome');
});


Route::middleware(['auth'])->group(function () {
    // Profile Page
    Route::view('profile', 'profile')->name('profile');

    Route::middleware(['verified'])->group(function () {
        // Dashboard
        Route::view('dashboard', 'dashboard')->name('dashboard');
        // Manajemen User
        Route::get('/users', DataUser::class)->name('users');
    });
});
