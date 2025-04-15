<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\UserController;
use App\Http\Controllers\Site\ProjectController;
use App\Http\Controllers\Site\BidController;
use App\Http\Controllers\Site\ChatController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\DisputeController;
use App\Http\Controllers\admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('site/welcome');
});

Route::middleware('auth')->group(function () {

    // SiteController
    Route::controller(SiteController::class)->group(function () {
        Route::get('/index', 'index')->name('site.index');
        Route::get('/chats', 'chats')->name('chats');
    });

    // ProjectController
    Route::controller(ProjectController::class)->group(function () {
        Route::get('/my-projects', 'customerProjects')->name('customerProjects');
        Route::get('/project/{id}', 'showProject')->name('project');
        Route::get('/projects', 'index')->name('projects');
        Route::get('/create-project', 'createProject')->name('project.create');
        Route::get('/edit-project/{id}', 'editProject')->name('project.edit');
        Route::post('/update-project', 'storeProject')->name('project.update');
        Route::post('/store-project', 'storeProject')->name('project.store');
        Route::post('/complete-project/{id}', 'closeProject')->name('closeProject');
    });

    // BidController
    Route::controller(BidController::class)->group(function () {
        Route::post('/make-bid', 'storeBid')->name('makeBid');
        Route::get('/accept-bid', 'acceptBid')->name('acceptBid');
        Route::get('/accepted-bids', 'acceptedBids')->name('acceptedBids');
    });

    // ChatController
    Route::controller(ChatController::class)->group(function () {
        Route::post('/chat', 'showChat')->name('showChat');
        Route::get('/chats/{user_id}', 'index')->name('showChats');
        Route::post('/send-message', 'storeMessage')->name('storeMessage');
    });

    // UserController
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/profile', 'index')->name('profile.index');
    });

    // ProfileController
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // ReviewController
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/leave-review', 'leaveReview')->name('review.create');
        Route::post('/store-review', 'storeReview')->name('review.store');
        Route::get('/freelancer-reviews/{id}', 'openFreelancerReview')->name('review.open');
    });

    // ReviewController
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/leave-review', 'leaveReview')->name('review.create');
        Route::post('/store-review', 'storeReview')->name('review.store');
        Route::get('/freelancer-reviews/{id}', 'openFreelancerReview')->name('review.open');
    });

    //DisputesController
    Route::controller(DisputeController::class)->group(function () {
        Route::post('/create-dispute', 'createDispute')->name('dispute.create');
        Route::post('/store-dispute', 'storeDispute')->name('dispute.store');
        Route::get('/disputes', 'index')->name('disputes');
    });

});

Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/disputes-resolve', [AdminController::class, 'disputes'])->name('admin.disputes');
        Route::post('/dispute-resolve/{id}', [AdminController::class, 'resolveDispute'])->name('admin.resolveDispute');
    });

Route::get('/dashboard', function () {
    return view('site/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
