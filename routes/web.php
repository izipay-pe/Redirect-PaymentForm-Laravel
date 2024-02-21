<?php

use App\Http\Controllers\IzipayController;
use Illuminate\Support\Facades\Route;


Route::get('/', [IzipayController::class, 'initPaymentForm']);
Route::post('/confirm', [IzipayController::class, 'confirm']);
Route::get('/status', [IzipayController::class, 'status']);
