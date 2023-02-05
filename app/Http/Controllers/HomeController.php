<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       if(!Auth::user()->is_admin==1){
        $data['orders']=DB::table('orders')->where('user_id',Auth::id())->orderBy('id','DESC')->take(10)->get();
        //total order
        $data['total_order']=DB::table('orders')->where('user_id',Auth::id())->count();
        $data['complete_order']=DB::table('orders')->where('user_id',Auth::id())->where('status',3)->count();
        $data['cancel_order']=DB::table('orders')->where('user_id',Auth::id())->where('status',5)->count();
        $data['return_order']=DB::table('orders')->where('user_id',Auth::id())->where('status',4)->count();

        return view('home',compact('data'));
        
        }else{
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/');
    }
    //Admin After login.....
    public function admin()
    {
        return view('admin.home');
    }
}
