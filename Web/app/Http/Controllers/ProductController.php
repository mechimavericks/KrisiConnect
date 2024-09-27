<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('user')->get(); // Fetch all products with their associated user
        return view('marketplace.index', compact('products'));
    }
}
