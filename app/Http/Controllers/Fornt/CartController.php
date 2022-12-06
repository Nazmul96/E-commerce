<?php

namespace App\Http\Controllers\Fornt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Cart;
use Auth;
use DB;

class CartController extends Controller
{
       //wishlist
       public function AddWishlist($id)
       {
   
           if(Auth::check()){
               $check=DB::table('wishlists')->where('product_id',$id)->where('user_id',Auth::id())->first();
                  if ($check) {
                        $notification=array('messege' => 'Already have it on your wishlist !', 'alert-type' => 'error');
                        return redirect()->back()->with($notification); 
                  }else{
                       $data=array();
                       $data['product_id']=$id;
                       $data['user_id']=Auth::id();
                       $data['date']=date('d , F Y');
                       DB::table('wishlists')->insert($data);
                       $notification=array('messege' => 'Product added on wishlist!', 'alert-type' => 'success');
                       return redirect()->back()->with($notification); 
                  }
           }
   
           $notification=array('messege' => 'Login Your Account!', 'alert-type' => 'error');
           return redirect()->back()->with($notification);  
       }

    public function AddToCartQV(Request $request)
    {

        $product=Product::find($request->id);

        Cart::add([
            'id'=>$product->id,
            'name'=>$product->name,
            'qty'=>$request->qty,
            'price'=>$request->price,
            'weight'=>'1',
            'options'=>['size'=>$request->size , 'color'=> $request->color ,'thumbnail'=>$product->thumbnail]

        ]);
        return response()->json("product added on cart!");
    }


    public function AllCart()
    {
       $data=array();
       $data['cart_qty']=Cart::count();
       $data['cart_total']=Cart::Total();

       return response()->json($data);
    }

}
