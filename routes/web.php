<?php

use App\Http\Controllers\UrlCheckController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', WelcomeController::class)->name('welcome');
Route::resource('urls', UrlController::class)->only(['index', 'show', 'store']);
Route::resource('urls.checks', UrlCheckController::class)->only(['store']);
