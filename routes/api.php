<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('widgets', \App\Http\Controllers\WidgetController::class);
Route::resource('file-sources', \App\Http\Controllers\FileSourceController::class);
Route::get('/widgets/{widget}/chat-possibilities', [\App\Http\Controllers\WidgetController::class, 'getWidgetChatPossibilities']);
Route::post('/widgets/{widget}/chat-possibilities', [\App\Http\Controllers\WidgetController::class, 'updateWidgetChatPossibilities']);

Route::post('/chatbot/messaging', [\App\Http\Controllers\ChatbotController::class, 'messaging'])
    ->middleware('throttle:600,1');

Route::get('/chatbot/{widget}/start-messaging', [\App\Http\Controllers\ChatbotController::class, 'startMessaging'])
    ->middleware('throttle:100,1');



