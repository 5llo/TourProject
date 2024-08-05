<?php

use App\Http\Controllers\AllToursController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthCustomerController;
use App\Http\Controllers\Api\AuthDesignerController;
use App\Http\Controllers\Api\AuthOfferController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DesignerController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TourController;
use App\Models\Customer;
use App\Models\Designer;
use App\Models\Offer;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Route::middleware('auth:sanctum')->post('/customer/logout', [AuthCustomerController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
});

Route::post('/customer/login',[AuthCustomerController::class,'login']);
Route::post('/customer/register',[AuthCustomerController::class,'register']);

Route::post('/designer/login',[AuthDesignerController::class,'login']);
Route::post('/offer/login',[AuthOfferController::class,'login']);



Route::middleware(['auth:sanctum','role:'.Designer::class])->group(function () {

     Route::resource('tour', TourController::class);
     Route::post('tour/show', [TourController::class,'show']);
     Route::post('tour/index', [TourController::class,'index']);
     Route::post('tour/delete', [TourController::class,'destroy']);
     Route::post('tour/update', [TourController::class,'update']);
     Route::get('designer/requests', [DesignerController::class,'requests']);
     Route::post('designer/answer', [DesignerController::class,'answer']);
     Route::get('designer/notifications', [DesignerController::class,'getallnotefication']);
     Route::post('/designer/logout', [AuthDesignerController::class, 'logout']);


    });
Route::middleware(['auth:sanctum','role:'.Offer::class])->group(function () {
    // Routes that require Sanctum authentication
    Route::post('/service/delete',[ServiceController::class,'delete']);
    Route::post('/service/index',[ServiceController::class,'index']);
    Route::post('/service/show',[ServiceController::class,'show']);
    Route::post('/service/store',[ServiceController::class,'store']);
    Route::post('/service/update',[ServiceController::class,'update']);
    //Route::post('/customer/logout', [AuthCustomerController::class, 'logout']);
    // Route::post('/designer/logout', [AuthDesignerController::class, 'logout']);
    Route::get('/offer/requests',[OfferController::class,'allRequest']);
    Route::post('/offer/request/answer',[OfferController::class,'answer']);
    Route::post('/offer/logout', [AuthOfferController::class, 'logout']);

});
Route::middleware(['auth:sanctum','role:'.Customer::class])->group(function () {

    Route::get('customer/alltour',[CustomerController::class,'AllTour']);
    Route::post('customer/join',[CustomerController::class,'joinTour']);
    Route::get('customer/booking',[CustomerController::class,'booking']);
    Route::get('customer/notifications',[CustomerController::class,'getallnote']);
    Route::post('/customer/logout', [AuthCustomerController::class, 'logout']);



});

Route::get('/admin/clear-cache', function () {
    try {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return response()->json(['message' => 'Cache cleared successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to clear cache', 'details' => $e->getMessage()], 500);
    }
});

Route::get('/test',function(){
     return "hello from the website  :)";
});
