<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('register', [UserController::class, 'getRegistration'])->name('register');
Route::post('register', [UserController::class, 'postRegistration'])->name('register');
Route::get('login', [UserController::class, 'getLogin'])->name('login');
Route::post('login', [UserController::class, 'postLogin'])->name('login');
Route::get('signout', [UserController::class, 'signOut'])->name('signout');
Route::get('main', [MainController::class, 'getMainPage'])->name('main');




