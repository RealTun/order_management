<?php

use App\Http\Controllers\OrderController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('orders', OrderController::class);
Route::post('/orders/create/t', [OrderController::class, 'getSelectType']);
Route::post('/orders/create/p', [OrderController::class, 'getSelectProduct']);
Route::post('/saveTable', [OrderController::class,'saveTable']);
Route::post('/order/store', [OrderController::class, 'store']);
Route::post('/update', [OrderController::class,'update'])->name('update');
Route::post('/updateop', [OrderController::class,'updateOrderProduct']);
Route::post('/delete', [OrderController::class, 'deleteRow']);
Route::post('/addRow', [OrderController::class,'addRow']);
Route::post('/remove', [OrderController::class, 'remove']);
