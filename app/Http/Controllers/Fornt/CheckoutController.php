<?php

namespace App\Http\Controllers\Fornt;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Cart;
use DB;

class CheckoutController extends Controller
{
    //__checkout page
    public function Checkout()
    {
        if (!Auth::check()) {     
             $notification=array('messege' => 'Login Your Account!', 'alert-type' => 'error');
             return redirect()->back()->with($notification);  
        }
        $content=Cart::content();
        return view('frontend.cart.checkout',compact('content'));

    }
}
