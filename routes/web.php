<?php

use App\Http\Controllers\ItemController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


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



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
