<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AdminProductController;
use App\Http\Controllers\Api\OrderController;


Route::get('/', function () {
    return view('welcome');
});
