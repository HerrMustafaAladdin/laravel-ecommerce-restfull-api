<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\BrandController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){

    //    ================================================================== Auth
    Route::post('/register',[AuthController::class, 'register']);
    Route::post('/login',[AuthController::class, 'login']);

    //    ================================================================== Route group set middleware Sanctum
    Route::prefix('/')->middleware('auth:sanctum')->group(function(){

        Route::post('logout',[AuthController::class, 'logout']);

        //    ================================================================== Brands
        Route::apiResource('brands',BrandController::class);
        Route::get('/brands/{brand}/products',[BrandController::class, 'products']);
        //    ================================================================== Category
        Route::apiResource('categories',CategoryController::class);
        Route::get('/categories/{category}/children',[CategoryController::class, 'children']);
        Route::get('/categories/{category}/parent',[CategoryController::class, 'parent']);
        Route::get('/categories/{category}/products',[CategoryController::class, 'products']);

        //    ================================================================== products
        Route::apiResource('products', ProductController::class);

        //    ================================================================== Payment
        Route::post('payment/send',[PaymentController::class,'send']);
        Route::post('payment/verify',[PaymentController::class,'verify']);
        
    });
});
