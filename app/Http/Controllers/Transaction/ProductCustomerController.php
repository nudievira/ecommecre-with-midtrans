<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;

class ProductCustomerController extends Controller
{
    public function index()
    {
        $product = Product::where('status', 1)->get();
        return view('product.indexCustomer', compact('product'));
    }

}
