<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //Admin After login.....

     public function admin()
     {
         
        $data['customers']=DB::table('users')->where('is_admin','0')->orWhere('is_admin',NULL)->orderBy('id','DESC')->limit(8)->get();
        $data['latest_order']=DB::table('orders')->orderBy('id','DESC')->limit(8)->get();
        $data['most_views']=DB::table('products')->orderBy('product_views','DESC')->where('status',1)->limit(8)->get();
        $data['product']=DB::table('products')->count();
        $data['active_product']=DB::table('products')->where('status',1)->count();
        $data['inactive_product']=DB::table('products')->where('status',0)->count();
        $data['allcustomers']=DB::table('users')->where('is_admin','0')->orWhere('is_admin',NULL)->count();
        $data['category']=DB::table('categories')->count();
        $data['brands']=DB::table('brands')->count();
        $data['tickets']=DB::table('tickets')->where('status',0)->count();
        $data['reviews']=DB::table('reviews')->count();
        $data['coupon']=DB::table('coupons')->count();
        $data['subscribers']=DB::table('newsletters')->count();
        $data['pending_order']=DB::table('orders')->where('status',0)->count();
        $data['success_order']=DB::table('orders')->where('status',3)->count();
 
         return view('admin.home',compact('data'));
     } 
    
    // admin custome Logout....
     public function logout()
     {
         Auth::logout();
         $notification=array(
             'message'=>'you are logged out!',
             'alert-type'=>'success',
         );
         return redirect()->route('admin_login')->with($notification);
     } 

     //admin Password Change.....

     public function passwordChange(){
         return view('admin.profile.admin_password_change');
     }

     //Admin Password Update....

     public function passwordUpdate(Request $req){
        $validatedData= $req->validate([
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed',           
        ]);
        $user=User::find(Auth::id());//current user data get
        $user_login_pass=$user->password; //already login user password get from  database

        
        $old_password=$req->old_password; //oldpassword get from input field
        
        if(Hash::check($old_password,$user_login_pass)){//checking password same or not   
            $user->password=Hash::make($req->password); //current user password hasing
            $user->save();//finally save the password
            Auth::logout();//logout the admin user and redirect admin login panel not user login panel
            $notification=array(
                'message'=>'Your Password changed!',
                'alert-type'=>'success',
            );
            return redirect()->route('admin_login')->with($notification);
        }
        else{
            $notification=array(
                'message'=>'Old password Not Matched!',
                'alert-type'=>'error',
            );
            return redirect()->back()->with($notification);
        }
       
     }















}
