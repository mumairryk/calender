<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
    return view('auth.login');
})->name('login');
Route::post('/auth', [AuthController::class,'login'])->name('auth');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/calender', function () {
        return view('welcome');
    });
    Route::get('/logout', [AuthController::class,'logout'])->name('logout');
});
