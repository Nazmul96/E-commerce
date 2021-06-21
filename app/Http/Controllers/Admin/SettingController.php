<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //seo page show method........
    public function seo(){
        $data=DB::table('seos')->first();
        return view('admin.setting.seo',compact('data'));
    }

    // update method for seo.........
    public function seoupdate(Request $req,$id){

        $data=array();
        $data['meta_title']=$req->meta_title;
        $data['meta_author']=$req->meta_author;
        $data['meta_keyword']=$req->meta_keyword;
        $data['meta_description']=$req->meta_description;
        $data['google_verification']=$req->google_verification;
        $data['google_analytics']=$req->google_analytics;
        $data['google_adsense']=$req->google_adsense;
        $data['alexa_verification']=$req->alexa_verification;

        DB::table('seos')->where('id',$id)->update($data);

        $notification=array(
            'message'=>'SEO Setting Updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
    }

    //smtp page show..........
    public function smtp(){
        $smtp=DB::table('smtp')->first();
        return view('admin.setting.smtp',compact('smtp'));
    }

    //update method for smtp......
    public function smtpupdate(Request $req,$id){
        $data=array();
       
        $data['mailer']=$req->mailer;
        $data['host']=$req->host;
        $data['port']=$req->port;
        $data['user_name']=$req->user_name;
        $data['password']=$req->password;

        DB::table('smtp')->where('id',$id)->update($data);

        $notification=array(
            'message'=>'SMTP Setting Updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }
}
