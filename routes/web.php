<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function(){
    return response()->json([
        'message'   => 'The program was executed'
    ],200);
});

Route::get('/payment/verify', function (Request $request) {
    $responce = Http::post('http://localhost:8000/api/v1/payment/verify',[
        'token'     =>  $request->token,
        'status'    =>  $request->status
    ]);
    return $responce->json();
});
