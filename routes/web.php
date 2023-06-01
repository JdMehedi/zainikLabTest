<?php

use App\Http\Controllers\AdminControllers;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShareButtonController;
use App\Http\Controllers\ShortLinkController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('admin')->group(function () {
    Route::get('/users', [AdminControllers::class, 'index'])->name('users.index');
    Route::patch('/user/update/{id}', [AdminControllers::class, 'update'])->name('users.update');
    Route::delete('/user/delete/{id}', [AdminControllers::class, 'destroy'])->name('users.delete');
});

Route::get('/post', [ShareButtonController::class, 'share'])->name('post.name');
Route::get('gen-short-link', [ShortLinkController::class, 'index'])->name('shortLink.show');
Route::post('gen-short-link', [ShortLinkController::class, 'store'])->name('generate.shorten.link.post');
Route::get('gen-short-link/{code}', [ShortLinkController::class, 'shortenLink'])->name('shorten.link');
require __DIR__ . '/auth.php';
