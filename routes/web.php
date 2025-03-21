<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\UserController;
use App\Http\Controllers\Site\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/index', [SiteController::class, 'index'])->middleware('auth')->name('index');
Route::get('/projects', [ProjectController::class, 'index'])->middleware('auth')->name('projects');
Route::get('/profile', [UserController::class, 'index'])->middleware('auth')->name('index');
Route::get('/chats', [SiteController::class, 'chats'])->middleware('auth')->name('chats');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
