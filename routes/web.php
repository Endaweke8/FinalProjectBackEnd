<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapaController;
use App\Http\Controllers\ContactController;
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
// The route that the button calls to initialize payment

Route::post('/pay', [ChapaController::class,'initialize'])->name('pay');

// The callback url after a payment
Route::get('callback/{reference}', [ChapaController::class,'callback'])->name('callback');

Route::view('/contact','contactForm')->name('contactForm');
Route::post('/send',[ContactController::class,'send'])->name('send.email');


