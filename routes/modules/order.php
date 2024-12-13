<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('orders', 'App\Http\Controllers\Api\Order\OrderController');
