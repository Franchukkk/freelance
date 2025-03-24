<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\UserController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\BidController;
use App\Http\Controllers\Site\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('site/welcome');
});

Route::get('/index', function () {
    return view('index');
});

Route::get('/dashboard', function () {
    return view('site/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/index', [SiteController::class, 'index'])
    ->middleware('auth')
    ->name('site.index');

Route::get('/projects', [ProjectController::class, 'index'])->middleware('auth')->name('projects');

Route::get('/my-projects', [ProjectController::class, 'customerProjects'])
    ->middleware('auth')
    ->name('customerProjects');

Route::get('/create-project', [ProjectController::class, 'createProject'])
    ->middleware('auth')
    ->name('project.create');

Route::post('/store-project', [ProjectController::class, 'storeProject']);

Route::get('/project/{id}', [ProjectController::class, 'showProject']);

Route::get('/user/profile', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('profile.index');

Route::get('/chats', [SiteController::class, 'chats'])->middleware('auth')->name('chats');

Route::post('/make-bid', [BidController::class, 'storeBid'])->middleware('auth')->name('makeBid');

Route::get('/accept-bid', [BidController::class, 'acceptBid'])->middleware('auth')->name('acceptBid');

Route::get('/accepted-bids', [BidController::class, 'acceptedBids'])->middleware('auth')->name('acceptedBids');

Route::post('/chat', [ChatController::class, 'showChat'])->middleware('auth')->name('showChat');

Route::get('/chats/{user_id}', [ChatController::class, 'index'])->middleware('auth')->name('showChats');

Route::post('/send-message', [ChatController::class, 'storeMessage'])->middleware('auth')->name('storeMessage');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
