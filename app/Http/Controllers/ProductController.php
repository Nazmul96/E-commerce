<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class ProductController extends Controller
{
    public function products(){
        $product=product::all();
        return view('pages.product.index',compact('product'));
    }
}
