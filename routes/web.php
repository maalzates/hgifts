<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::redirect('/', 'login');

// ONLY AUTHENTICATED USERS (REGARDELESS THE ROLE) CAN ACCESS
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // CAMPAIGNS
    // List show
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    // Show view route
    Route::get('campaigns/{campaign}/show', [CampaignController::class, 'show'])->name('campaigns.show')->middleware('can:view,campaign');
    // Update edited information route
    Route::put('campaigns/{campaign}', [CampaignController::class, 'update'])->name('campaigns.update');


    // COMMENTS 
    Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');
    //Store
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    // Delete
    Route::delete('comments', [CampaignController::class, 'destroy'])->name('comments.destroy')->middleware('web');;
});


// ONLY AUTHENTICATED USERS WITH ADMIN ROLE 
Route::middleware([
    'auth:sanctum', 
    config('jetstream.auth_session'),
    'verified',
    AdminMiddleware::class
])->group(function () {
    
    // CAMPAIGNS 
    // Create record route
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    // Store the created record route
    Route::post('campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    // Edit view route
    Route::get('campaigns/{campaign}/edit', [CampaignController::class, 'edit'])->name('campaigns.edit');
    // Delete record route
    Route::delete('campaigns/{campaign}', [CampaignController::class, 'destroy'])->name('campaigns.destroy');

    // ITEMS
    // List show
    Route::get('/items', [ItemController::class, 'index'])->name('items.index');
    // Create record route
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    // Store the created record route
    Route::post('items', [ItemController::class, 'store'])->name('items.store');
    // Edit view route
    Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    // Update edited information route
    Route::put('items/{item}', [ItemController::class, 'update'])->name('items.update');
    // Delete record route
    Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');


    // USERS
    Route::resource('users', UserController::class)->names('users');


});

// Redirects all non found routes to /campaigns
Route::fallback(function () {
    return redirect('/campaigns');
});