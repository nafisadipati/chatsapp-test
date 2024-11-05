<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\AuthController;

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

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/chatrooms', [ChatroomController::class, 'list'])->name('chatrooms.list');
    Route::get('/chatrooms-view', [ChatroomController::class, 'index'])->name('chatrooms.index');
    Route::get('/chatrooms/{id}', [ChatroomController::class, 'show'])->name('chatrooms.show');
    Route::post('/chatrooms', [ChatroomController::class, 'create'])->name('chatrooms.create');
    Route::get('/chatrooms/{id}/enter', [ChatroomController::class, 'enter'])->name('chatrooms.enter');
    Route::get('/chatrooms/{id}/leave', [ChatroomController::class, 'leave'])->name('chatrooms.leave');
});
