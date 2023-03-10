<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/chatbot/{widget}', [\App\Http\Controllers\ChatbotController::class, 'getChatbot'])->name('get-chat');

Route::get('/chatbot-test', function() {
    return view('test-chat');
});

