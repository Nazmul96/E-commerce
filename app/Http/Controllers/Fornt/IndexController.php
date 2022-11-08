<?php

namespace App\Http\Controllers\Fornt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use DB;

class IndexController extends Controller
{
    public function index()
    {
        $category=Category::get();
        $banner_product=Product::where('product_slider',1)->latest()->first();
        //dd($banner_product);
        return view('frontend.index',compact('category','banner_product'));
    }

    public function product_details($slug)
    {
        $product=Product::where('slug',$slug)->first();
        $related_product=DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();
        return view('frontend.product_details',compact('product','related_product'));
    }
}
