<?php

namespace App\Http\Controllers\Fornt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}
