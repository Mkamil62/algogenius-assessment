<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Analytics API routes
Route::prefix('analytics')->group(function () {
    Route::get('/summary', [AnalyticsController::class, 'getSummary']);
    Route::get('/sales-trend', [AnalyticsController::class, 'getSalesTrend']);
    Route::get('/top-products', [AnalyticsController::class, 'getTopProducts']);
});