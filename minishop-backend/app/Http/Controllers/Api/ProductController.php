<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::where('status', 'ACTIVE')->get();
    }


    public function show($id)
    {
        return Product::findOrFail($id);
    }
}
