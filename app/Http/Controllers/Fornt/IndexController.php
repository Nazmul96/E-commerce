<?php

namespace App\Http\Controllers\Fornt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use DB;

class IndexController extends Controller
{
    public function index()
    {
        $category=Category::get();
        $banner_product=Product::where('product_slider',1)->latest()->first();
        $feature_product=Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(16)->get();
        $popular_product=Product::where('status',1)->orderBy('product_views','DESC')->limit(8)->get();
        return view('frontend.index',compact('category','banner_product','feature_product','popular_product'));
    }

    public function product_details($slug)
    {
        /* product views count */
        Product::where('slug',$slug)->increment('product_views');

        $product=Product::where('slug',$slug)->first();
        $related_product=DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();
        $review=Review::where('product_id',$product->id)->orderBy('id','DESC')->take(10)->get();
        return view('frontend.product_details',compact('product','related_product','review'));
    }
}
