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
        $category=DB::table('categories')->orderBy('category_name','ASC')->get();
        $banner_product=Product::where('product_slider',1)->latest()->first();
        $feature_product=Product::where('status',1)->where('featured',1)->orderBy('id','DESC')->limit(16)->get();
        $popular_product=Product::where('status',1)->orderBy('product_views','DESC')->limit(8)->get();
        $trendy_product=Product::where('status',1)->where('trendy_product',1)->orderBy('id','DESC')->limit(8)->get();
        $website_review=DB::table('website_reviews')->where('status',1)->orderBy('id','DESC')->limit(12)->get();
        //homepage category
        $home_category=DB::table('categories')->where('home_page',1)->orderBy('category_name','ASC')->get();

        $brand=DB::table('brands')->where('front_page',1)->limit(24)->get();
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        $todaydeal=Product::where('status',1)->where('today_deal',1)->orderBy('id','DESC')->limit(6)->get();

        $campaign=DB::table('campaigns')->where('status',1)->orderBy('id','DESC')->first();

        return view('frontend.index',compact('category','banner_product','feature_product','popular_product','trendy_product','home_category','brand','random_product','todaydeal','website_review','campaign'));
    }

    public function product_details($slug)
    {
        /* product views count */
        Product::where('slug',$slug)->increment('product_views');
          
        $product=Product::where('slug',$slug)->first(); 
        $related_product=DB::table('products')->where('subcategory_id',$product->subcategory_id)->orderBy('id','DESC')->take(10)->get();
        $review=Review::where('product_id',$product->id)->orderBy('id','DESC')->take(10)->get();

         // Share button 1
         $shareButtons1 = \Share::page(
                url()->current()
            )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp() 
            ->reddit();
      
        return view('frontend.product.product_details',compact('product','related_product','review','shareButtons1'));
    }

    //product quick view
    public function ProductQuickView($id)
    {
        $product=Product::where('id',$id)->first();
        //dd($product);
        return view('frontend.product.quick_view',compact('product'));
    }

     //categorywise product page
     public function categoryWiseProduct($id)
     {
         $category=DB::table('categories')->where('id',$id)->first();
         $subcategory=DB::table('subcategories')->where('category_id',$id)->get();
         $brand=DB::table('brands')->get();
         $products=DB::table('products')->where('category_id',$id)->paginate(60);
         $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
         return view('frontend.product.category_products',compact('subcategory','brand','products','random_product','category'));
 
     }

     //subcategorywise product
    public function SubcategoryWiseProduct($id)
    {
        $subcategory=DB::table('subcategories')->where('id',$id)->first();
        $childcategories=DB::table('childcategories')->where('subcategory_id',$id)->get();
        $brand=DB::table('brands')->get();
        $products=DB::table('products')->where('subcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        return view('frontend.product.subcategory_product',compact('childcategories','brand','products','random_product','subcategory'));
    }

    //childcategory product
    public function ChildcategoryWiseProduct($id)
    {
        $childcategory=DB::table('childcategories')->where('id',$id)->first();
        $categories=DB::table('categories')->get();
        $brand=DB::table('brands')->get();
        $products=DB::table('products')->where('childcategory_id',$id)->paginate(60);
        $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
        return view('frontend.product.childcategory_product',compact('categories','brand','products','random_product','childcategory'));
    }

      //brandwise product
      public function BrandWiseProduct($id)
      {
          $brand=DB::table('brands')->where('id',$id)->first();
          $categories=DB::table('categories')->get();
          $brands=DB::table('brands')->get();
          $products=DB::table('products')->where('brand_id',$id)->paginate(60);
          $random_product=Product::where('status',1)->inRandomOrder()->limit(16)->get();
          return view('frontend.product.brandwise_product',compact('categories','brands','products','random_product','brand'));
      }

    //page view method
    public function ViewPage($page_slug)
    {
        $page=DB::table('pages')->where('page_slug',$page_slug)->first();
        return view('frontend.page.page',compact('page'));
    }

    //store newsletter
    public function storeNewsletter(Request $request)
    {
        $email=$request->email;
        $check=DB::table('newsletters')->where('email',$email)->first();
        if ($check) {
            return response()->json('Email Already Exist!');
        }else{
                $data=array();
                $data['email']=$request->email;
                DB::table('newsletters')->insert($data);
                return response()->json('Thanks for subscribe us!');  
        }
    }

    //__order tracking page
    public function OrderTracking()
    {
        return view('frontend.order.order_tracking');
    }

    //__check orer
    public function CheckOrder(Request $request)
    {
        $check=DB::table('orders')->where('order_id',$request->order_id)->first();
        if ($check) {
            $order=DB::table('orders')->where('order_id',$request->order_id)->first();
            $order_details=DB::table('order_details')->where('order_id',$order->id)->get();
            return view('frontend.order.order_details',compact('order','order_details'));
        }else{
            $notification=array('messege' => 'Invalid OrderID! Try again.', 'alert-type' => 'error');
            return redirect()->back()->with($notification);
        }
    }

     //constact page
     public function Contact()
     {
         return view('frontend.contact');
     }
 
    //__blog page
    public function Blog()
    {
        return view('frontend.blog');
    }

}
