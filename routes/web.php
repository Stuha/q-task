<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
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

Route::get('/profile', DashboardController::class)->name('dashboard')->middleware('auth.session');

Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(AuthorController::class)->group(function () {
    Route::get('/author', 'index')->name('authors.index');
    Route::get('/author/{id}', 'show')->name('author.show');
    Route::delete('/author/{id}', 'delete')->name('author.delete');
});

Route::controller(BookController::class)->group(function () {
    Route::get('/book', 'create')->name('book.create');
    Route::post('/book', 'store')->name('book.store');
    Route::delete('/book/{id}/{author_id}', 'delete')->name('book.delete');
});
