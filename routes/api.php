<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\ChapaController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\AskStockController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StudenttController;
use App\Http\Controllers\SellStockController;
use App\Http\Controllers\StockOrderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ClientAddressController;
use App\Http\Controllers\ProductFeatureController;
use App\Http\Controllers\API\NewPasswordController;
use App\Http\Controllers\OrderprocessingController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\API\ForgotPasswordController;
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
Route::post('forget-password',[NewPasswordController::class,'forgetPassword']);
Route::post('email-verification',[EmailVerificationController::class,'email_verification']);
Route::post('forget-password',[ForgotPasswordController::class,'ForgetPassword']);
Route::post('reset-password',[ResetPasswordController::class,'ResetPassword']);
Route::post('change-password',[ChangePasswordController::class,'ChangePassword']);
Route::post('testverify',[TestController::class,'please']);

Route::middleware('auth:sanctum')->group(function(){


    Route::get('/get_total_users',[UserController::class,'get_total_users']);
    Route::get('/get_total_products',[ProductController::class,'get_total_products']);
    Route::get('/get_total_soldproducts',[ProductController::class,'get_total_soldproducts']);

    Route::get('/get_total_stocks',[StockController::class,'get_total_stocks']);
    Route::get('/get_total_messages',[MessageController::class,'get_total_messages']);
    Route::get('/get_total_stockorder',[StockOrderController::class,'get_total_stockorder']);
    Route::get('/get_total_stockasked',[AskStockController::class,'get_total_stockasked']);
    Route::get('/get_total_pendingorders',[OrderprocessingController::class,'get_total_pendingorders']);
    Route::get('/get_total_deliveredorders',[OrderprocessingController::class,'get_total_deliveredorders']);
    Route::get('/get_total_acceptedorders',[OrderprocessingController::class,'get_total_acceptedorders']);
    Route::get('/get_total_sellstockrequested',[SellStockController::class,'get_total_sellstockrequested']);
    Route::get('/get_total_notifiedorders',[OrderprocessingController::class,'get_total_notifiedorders']);

   

    Route::get('/get_total_transactions',[\App\Http\Controllers\OrderprocessingController::class,'get_total_transactions']);
    Route::get('/get_total_sales',[\App\Http\Controllers\OrderprocessingController::class,'get_total_sales']);
    Route::get('users/{id}', [\App\Http\Controllers\API\UserController::class, 'show']);
    Route::put('users/{id}', [\App\Http\Controllers\API\UserController::class, 'update']);
    Route::put('password/{id}', [\App\Http\Controllers\API\UserController::class, 'passwordupdate']);
    Route::get('user/{id}', [\App\Http\Controllers\API\UserController::class, 'showadminuser']);
    Route::delete('customer/{id}', [\App\Http\Controllers\API\UserController::class, 'destroy']);
    Route::delete('category/{id}', [CategoryController::class, 'destroy']);
    Route::get('getcategory/{id}', [CategoryController::class, 'show']);
    Route::put('editcategory/{id}', [CategoryController::class, 'update']);
    Route::put('make_category_active/{id}', [CategoryController::class, 'Active']);
    Route::delete('stockrequest/{id}', [\App\Http\Controllers\AskStockController::class, 'destroy']);
    

    Route::delete('message/{id}', [\App\Http\Controllers\MessageController::class, 'destroy']);
    Route::delete('order/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'destroy']);
    Route::put('markasdelivered/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'MarkAsDelivered']);
    Route::put('notifydeliveryman/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'NotifyDeliveryMan']);
    Route::put('notifyasaccepted/{id}', [\App\Http\Controllers\OrderprocessingController::class, 'NotifyAsAccepted']);


    Route::post('/searchuser',[\App\Http\Controllers\UserController::class,'searchUser']);
    
    Route::post('/searchmessage',[\App\Http\Controllers\MessageController::class,'searchMessage']);

    Route::post('/searchstock',[\App\Http\Controllers\StockController::class,'searchStock']);

    Route::post('/searchStockRequests',[\App\Http\Controllers\AskStockController::class,'searchStockRequest']);
    Route::post('/searchStockOrder',[\App\Http\Controllers\StockOrderController::class,'searchStockOrder']);
    
    Route::post('/searchsellStockRequests',[\App\Http\Controllers\SellStockController::class,'searchsellStockRequests']);


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

    Route::get('/get_all_users',[UserController::class,'get_all_users']);
    Route::get('/get_all_categories',[CategoryController::class,'get_all_categories']);
    Route::get('/get_all_employees',[UserController::class,'get_all_employees']);
Route::get('/get_all_messages',[MessageController::class,'get_all_messages']);
Route::get('/get_all_todaysmessagesreport',[MessageController::class,'get_all_todaysmessagesreport']);


Route::get('/get_all_products',[AdminProductController::class,'get_all_products']);
Route::get('/get_all_soldproducts',[AdminProductController::class,'get_all_soldproducts']);


Route::get('/getdailyreportorders',[OrderprocessingController::class,'getDailyReportOrders']);



Route::get('/orders',[OrderprocessingController::class,'getOrders']);
Route::get('/pendingorders',[OrderprocessingController::class,'getPendingOrders']);
Route::get('/deliveredorders',[OrderprocessingController::class,'getDeliveredOrders']);
Route::get('/notifiedorders',[OrderprocessingController::class,'getNotifiedOrders']);
Route::get('/acceptedorders',[OrderprocessingController::class,'acceptedOrders']);
Route::get('/getdailyacceptedreportorders',[OrderprocessingController::class,'getDailyAcceptedReportOrders']);
Route::get('/getdailpendingreportorders',[OrderprocessingController::class,'getDailyPendingReportOrders']);
Route::get('/getdailydeliveredreportorders',[OrderprocessingController::class,'getDailyDeliveredReportOrders']);


Route::get('/getweeklyreportorders',[OrderprocessingController::class,'getWeeklyReportOrders']);
Route::get('/getweeklydeliveredreportorders',[OrderprocessingController::class,'getWeeklyDeliveredReportOrders']);
Route::get('/weeklyacceptedreportorders',[OrderprocessingController::class,'getWeeklyAcceptedReportOrders']);
Route::get('/getweeklypendingreportorders',[OrderprocessingController::class,'getWeeklyPendingReportOrders']);



Route::get('/get_all_sellstockrequests',[SellStockController::class,'get_all_sellstockrequests']);
Route::get('/get_all_stockrequests',[AskStockController::class,'get_all_stockrequests']);
Route::get('/get_all_stockorders',[StockOrderController::class,'get_all_stockorders']);

Route::get('/get_all_sellstockrequestsweeklyreport',[SellStockController::class,'get_all_sellstockrequestsweeklyreport']);
Route::get('/get_all_stockrequestsweeklyreport',[AskStockController::class,'get_all_stockrequestsweeklyreport']);



Route::get('/get_all_stockordersdailyreport',[StockOrderController::class,'get_all_stockordersdailyreport']);
Route::get('/get_all_stockrequestsdailyreport',[AskStockController::class,'get_all_stockrequestsdailyreport']);
Route::get('/get_all_sellstockrequestsdailyreport',[SellStockController::class,'get_all_sellstockrequestsdailyreport']);
 
 });


// Route::middleware('auth:sanctum')->group(function(){
//    Route::get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('/logout',[AuthController::class,'logout']);
// });

Route::post('/saveproduct',[ProductController::class,'store']);
Route::post('/saveimage',[ImageController::class,'store']);
Route::post('/savestock',[StockController::class,'store']);
Route::post('/sellstock',[SellStockController::class,'store']);
Route::post('/askstock',[AskStockController::class,'store']);

Route::post('/getImagePath',[ProductController::class,'getImagePath']);
Route::post('/getstockimagepath',[StockController::class,'getStockImagePath']);

Route::post('/getvideopath',[ProductController::class,'getVideoPath']);
Route::post('/getImagePathMore',[ImageController::class,'getImagePathMore']);
Route::post('/upload',[ProductController::class,'uploadpost']);

Route::post('/savemessage',[MessageController::class,'store']);
Route::post('/savestockorder',[StockOrderController::class,'store']);

Route::get('/products',[ProductController::class,'index']);
Route::get('/latestproducts',[ProductController::class,'latestproducts']);
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


Route::get('/products/electronics/televisions',[ProductController::class,'Televisions']);
Route::get('/products/electronics/headsets',[ProductController::class,'HeadSets']);


Route::get('/products/electronics/desktopcomputers',[ProductController::class,'DesktopComputers']);
Route::get('/products/electronics/mobiles/iphones',[ProductController::class,'IphoneMobiles']);
Route::get('/products/electronics/mobiles/androids',[ProductController::class,'AndroidMobiles']);
Route::get('/products/electronics/mobiles/buttons',[ProductController::class,'ButtonMobiles']);



Route::get('/products/clothes/mens/trousers',[ProductController::class,'MensTrousers']);
Route::get('/products/clothes/mens/tshirts',[ProductController::class,'MensTshirts']);
Route::get('/products/clothes/mens/jackets',[ProductController::class,'MensJackets']);
Route::get('/products/clothes',[ProductController::class,'Clothes']);
Route::get('product/{id}',[ProductController::class,'show']);
Route::get('category/{id}',[ProductController::class,'getCategory']);

Route::get('getsingleproduct/{id}',[ProductController::class,'showSingleProduct']);
Route::get('stock/{id}',[StockController::class,'show']);
Route::put('stock/{id}', [StockController::class, 'update']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::put('decreaseproduct/{id}', [ProductController::class, 'DecreaseProduct']);

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

Route::delete('cartafterpayment/{id}', [CartsController::class, 'DestroyCartAterPayment']);
// Route::post('/register',[AuthController::class,'register']);
// Route::post('/login',[AuthController::class,'login']);


Route::post('/bookmark/{id}',[BookmarkController::class,'store']);
Route::get('bookmark/{id}',[BookmarkController::class,'show']);
Route::delete('bookmarks/{id}',[BookmarkController::class,'ClearBookmarks']);
Route::delete('bookmark/{id}', [BookmarkController::class, 'destroy']);



Route::get('/notifications',[NotificationController::class,'index']);
Route::put('/notification/{id}', [NotificationController::class, 'update']);

Route::post('/saveLike',[LikeController::class,'saveLike']);

Route::post('/add-rate',[RatingController::class,'addRate']);
Route::get('rates/{id}',[RatingController::class,'show']);



Route::get('/add-studnett',[StudenttController::class,'create']);

Route::post('/pay', [ChapaController::class,'initialize']);
Route::get('callback/{reference}', [ChapaController::class,'callback']);
Route::post('/paymentchapatotable',[ChapaController::class,'processPayment']);
Route::post('/sendemail',[ContactController::class,'send']);


Route::post('/addcategory',[CategoryController::class,'store']);
Route::get('/getcategories',[CategoryController::class,'index']);
Route::get('/getactivecategories',[CategoryController::class,'ActiveCategory']);

Route::post('/addsubcategory',[SubCategoryController::class,'store']);

Route::get('getdetailorderresponse/{id}',[OrderprocessingController::class,'showOrderResponseDetail']);

Route::get('getrelatedproducts/{id}',[ProductController::class,'getRelatedProducts']);
Route::post('/sendcomment',[CommentController::class,'store']);

Route::get('getcommentimages/{id}', [CommentController::class, 'show']);
Route::put('editusercomment/{id}', [CommentController::class, 'update']);

Route::get('getcommentusername/{id}', [CommentController::class, 'showName']);
Route::delete('comment/{id}',[CommentController::class,'destroy']);

Route::delete('removefrommoreproductimage/{id}',[ImageController::class,'destroy']);

Route::put('editmoreproductimage/{id}', [ImageController::class, 'update']);
Route::post('/saveaddress',[ClientAddressController::class,'store']);
Route::get('clientaddressbyid/{id}',[ClientAddressController::class,'show']);
Route::put('updateaddress/{id}', [ClientAddressController::class, 'update']);

Route::post('/addproductfeature',[ProductFeatureController::class,'store']);
Route::get('getproductfeature/{id}', [ProductFeatureController::class, 'show']);
Route::put('updateproductfeature/{id}', [ProductFeatureController::class, 'update']);
Route::delete('removeproductfeature/{id}', [ProductFeatureController::class, 'destroy']);


