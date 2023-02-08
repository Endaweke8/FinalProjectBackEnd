<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\ChapaController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\StudenttController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderprocessingController;
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
 
    Route::get('/get_total_users',[UserController::class,'get_total_users']);
    Route::get('/get_total_products',[ProductController::class,'get_total_products']);
    Route::get('/get_total_transactions',[\App\Http\Controllers\OrderprocessingController::class,'get_total_transactions']);
    Route::get('/get_total_sales',[\App\Http\Controllers\OrderprocessingController::class,'get_total_sales']);
    Route::get('users/{id}', [\App\Http\Controllers\API\UserController::class, 'show']);
    Route::put('users/{id}', [\App\Http\Controllers\API\UserController::class, 'update']);
    Route::put('password/{id}', [\App\Http\Controllers\API\UserController::class, 'passwordupdate']);
    Route::get('user/{id}', [\App\Http\Controllers\API\UserController::class, 'showadminuser']);
    Route::delete('customer/{id}', [\App\Http\Controllers\API\UserController::class, 'destroy']);
    Route::delete('order/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'destroy']);
    Route::put('markasdelivered/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'MarkAsDelivered']);

    Route::post('/searchuser',[\App\Http\Controllers\UserController::class,'searchUser']);
    Route::post('/searchstock',[\App\Http\Controllers\StockController::class,'searchStock']);

    Route::post('/searchorder',[\App\Http\Controllers\OrderprocessingController::class,'searchOrder']);
    Route::post('/searchorderresponse',[\App\Http\Controllers\OrderprocessingController::class,'searchOrderResponse']);


    Route::post('/searchproduct',[\App\Http\Controllers\AdminProductController::class,'searchProduct']);

    Route::post('songs', [\App\Http\Controllers\API\SongController::class, 'store']);
    Route::delete('songs/{id}/{user_id}', [\App\Http\Controllers\API\SongController::class, 'destroy']);
    

    Route::get('youtube/{user_id}', [\App\Http\Controllers\API\YoutubeController::class, 'show']);
    Route::post('youtube', [\App\Http\Controllers\API\YoutubeController::class, 'store']);
    Route::delete('youtube/{id}', [\App\Http\Controllers\API\YoutubeController::class, 'destroy']);

    Route::get('getOrderResponse/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'show']);

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
Route::post('/savestock',[StockController::class,'store']);
Route::post('/getImagePath',[ProductController::class,'getImagePath']);
Route::post('/upload',[ProductController::class,'uploadpost']);


Route::get('/products',[ProductController::class,'index']);
Route::get('/stocks',[StockController::class,'index']);
Route::get('/forslideproducts',[ProductController::class,'ShowAllProductsForSlide']);
Route::get('/fromallproducts',[ProductController::class,'AllProducts']);
Route::get('/products/electronics',[ProductController::class,'Electronics']);


Route::get('/products/electronics/laptopcomputers',[ProductController::class,'LaptopComputers']);
Route::get('/products/electronics/hplaptopcomputers',[ProductController::class,'HpLaptopComputers']);
Route::get('/products/electronics/lenevolaptopcomputers',[ProductController::class,'LenevoLaptopComputers']);
Route::get('/products/electronics/applelaptopcomputers',[ProductController::class,'AppleLaptopComputers']);


Route::get('/products/electronics/hpdesktopcomputers',[ProductController::class,'HpDesktopComputers']);
Route::get('/products/electronics/appledesktopcomputers',[ProductController::class,'AppleDesktopComputers']);
Route::get('/products/electronics/lenevodesktopcomputers',[ProductController::class,'LenevoDesktopComputers']);

Route::get('/products/electronics/desktopcomputers',[ProductController::class,'DesktopComputers']);
Route::get('/products/electronics/mobiles/iphones',[ProductController::class,'IphoneMobiles']);
Route::get('/products/electronics/mobiles/androids',[ProductController::class,'AndroidMobiles']);
Route::get('/products/electronics/mobiles/buttons',[ProductController::class,'ButtonMobiles']);



Route::get('/products/clothes/mens/trousers',[ProductController::class,'MensTrousers']);
Route::get('/products/clothes/mens/tshirts',[ProductController::class,'MensTshirts']);
Route::get('/products/clothes/mens/jackets',[ProductController::class,'MensJackets']);
Route::get('/products/clothes',[ProductController::class,'Clothes']);
Route::get('product/{id}',[ProductController::class,'show']);
Route::get('getsingleproduct/{id}',[ProductController::class,'showSingleProduct']);
Route::get('stock/{id}',[StockController::class,'show']);
Route::put('stock/{id}', [StockController::class, 'update']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);

Route::post('/search',[ProductController::class,'searchProduct']);

Route::post('/cart/{id}',[CartsController::class,'store']);
Route::get('cart/{id}',[CartsController::class,'show']);
Route::get('getcart/{id}',[CartsController::class,'getCart']);
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
Route::get('/orders',[OrderprocessingController::class,'getOrders']);

Route::get('/notifications',[NotificationController::class,'index']);
Route::put('/notification/{id}', [NotificationController::class, 'update']);

Route::post('/saveLike',[LikeController::class,'saveLike']);

Route::post('/add-rate',[RatingController::class,'addRate']);
Route::get('rates/{id}',[RatingController::class,'show']);



Route::get('/add-studnett',[StudenttController::class,'create']);

Route::post('/pay', [ChapaController::class,'initialize']);
Route::get('callback/{reference}', [ChapaController::class,'callback']);
Route::post('/paymentchapatotable',[ChapaController::class,'processPayment']);