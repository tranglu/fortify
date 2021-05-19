<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;

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

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    });
//    Route::get('/secret', function () {
//        return view('secret');
//    })->middleware('password.confirm');
});
Route::get('/secret', function () {
    return view('secret');
})->middleware('password.confirm');
Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware(['auth'])
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
//Route::get('/home', function () {
//    return view('home');
//})->middleware(['auth','verified']);
//Auth::routes(['verify' => true]);