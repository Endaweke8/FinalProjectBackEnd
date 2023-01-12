<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\StudenttController;
use App\Http\Controllers\AdminProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('users/{id}', [\App\Http\Controllers\API\UserController::class, 'show']);
    Route::put('users/{id}', [\App\Http\Controllers\API\UserController::class, 'update']);



    Route::post('songs', [\App\Http\Controllers\API\SongController::class, 'store']);
    Route::delete('songs/{id}/{user_id}', [\App\Http\Controllers\API\SongController::class, 'destroy']);
    

    Route::get('youtube/{user_id}', [\App\Http\Controllers\API\YoutubeController::class, 'show']);
    Route::post('youtube', [\App\Http\Controllers\API\YoutubeController::class, 'store']);
    Route::delete('youtube/{id}', [\App\Http\Controllers\API\YoutubeController::class, 'destroy']);



    Route::get('posts', [\App\Http\Controllers\API\PostController::class, 'index']);
    Route::get('posts/{id}', [\App\Http\Controllers\API\PostController::class, 'show']);
    Route::post('posts', [\App\Http\Controllers\API\PostController::class, 'store']);
    Route::put('posts/{id}', [\App\Http\Controllers\API\PostController::class, 'update']);
    Route::delete('posts/{id}', [\App\Http\Controllers\API\PostController::class, 'destroy']);


    Route::get('user/{user_id}/songs', [\App\Http\Controllers\API\SongsByUserController::class, 'show']);
    Route::get('user/{user_id}/posts', [\App\Http\Controllers\API\PostsByUserController::class, 'show']);



    Route::post('logout', [AuthController::class, 'logout']);

 
 });


// Route::middleware('auth:sanctum')->group(function(){
//    Route::get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('/logout',[AuthController::class,'logout']);
// });

Route::post('/saveproduct',[ProductController::class,'store']);
Route::post('/getImagePath',[ProductController::class,'getImagePath']);
Route::post('/upload',[ProductController::class,'uploadpost']);


Route::get('/products',[ProductController::class,'index']);
Route::get('/fromallproducts',[ProductController::class,'AllProducts']);
Route::get('/products/electronics',[ProductController::class,'Electronics']);
Route::get('/products/electronics/laptopcomputers',[ProductController::class,'LaptopComputers']);
Route::get('/products/electronics/desktopcomputers',[ProductController::class,'DesktopComputers']);
Route::get('/products/electronics/mobiles/iphones',[ProductController::class,'IphoneMobiles']);
Route::get('/products/electronics/mobiles/androids',[ProductController::class,'AndroidMobiles']);
Route::get('/products/electronics/mobiles/buttons',[ProductController::class,'ButtonMobiles']);
Route::get('/products/clothes',[ProductController::class,'Clothes']);
Route::get('product/{id}',[ProductController::class,'show']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);

Route::post('/search',[ProductController::class,'searchProduct']);

Route::post('/cart/{id}',[CartsController::class,'store']);
Route::get('cart/{id}',[CartsController::class,'show']);
Route::post('/removeFromCart',[CartsController::class,'RemoveFromCart']);
Route::get('/checkout/{id}',[CartsController::class,'getCartItemsForCheckout']);
Route::post('/payment',[CartsController::class,'processPayment']);
Route::delete('clearCartItem/{id}',[CartsController::class,'clearCartItem']);

Route::delete('cart/{id}', [CartsController::class, 'destroy']);
// Route::post('/register',[AuthController::class,'register']);
// Route::post('/login',[AuthController::class,'login']);


Route::post('/bookmark/{id}',[BookmarkController::class,'store']);
Route::get('bookmark/{id}',[BookmarkController::class,'show']);
Route::delete('bookmarks/{id}',[BookmarkController::class,'ClearBookmarks']);
Route::delete('bookmark/{id}', [BookmarkController::class, 'destroy']);

Route::get('/get_all_users',[UserController::class,'get_all_users']);
Route::get('/get_all_products',[AdminProductController::class,'get_all_products']);



Route::post('/saveLike',[LikeController::class,'saveLike']);

Route::post('/add-rate',[RatingController::class,'addRate']);
Route::get('rates/{id}',[RatingController::class,'show']);

Route::get('/add-studnett',[StudenttController::class,'create']);