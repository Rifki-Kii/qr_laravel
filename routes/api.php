<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ScanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('salam', function () {
    return response()->json([
    'status' => 'success',
    'message' => 'salam dari dunia'
    ]);
});

Route::post('/login', [ApiAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);


Route::get("scan", [ScanController::class,"index"]);

route::get ("scan/{id}", [ScanController::class,"show"]);

Route::post("scan", [ScanController::class,"store"]);

route::put ("scan/{id}", [ScanController::class,"update"]);

route::delete ("scan/{id}", [ScanController::class,"destroy"]);
});
