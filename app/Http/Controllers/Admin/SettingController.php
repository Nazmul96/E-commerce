<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image; //for image intervention package
use File;

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


    //website setting.......

    public function website_setting(){
        $setting=DB::table('website_settings')->first();
        return view('admin.setting.website_setting',compact('setting'));
    }

    //website setting update.......

    public function website_setting_update(Request $req,$id){

        $data=array();
        $data['currency']=$req->currency;
        $data['phone_one']=$req->phone_one;
        $data['phone_two']=$req->phone_two;
        $data['main_email']=$req->main_email;
        $data['support_email']=$req->support_email;
        $data['address']=$req->address;
        $data['facebook']=$req->facebook;
        $data['twitter']=$req->twitter;
        $data['instagram']=$req->instagram;
        $data['linkedin']=$req->linkedin;
        $data['youtube']=$req->youtube;

        
		$favicon=$req->favicon;
		$logo=$req->logo;
		if($logo){
			if(File::exists($req->old_logo)){
				unlink($req->old_logo);
			}
			$logo_name=uniqid().'.'.strtolower($logo->getClientOriginalExtension()); //unique nmae generate every time		    
            $upload_path='public/files/setting/';
			Image::make($logo)->resize(320,120)->save('public/files/setting/'.$logo_name); //image intervension package use

		    $data['logo']=$upload_path.$logo_name;
		}
		else{
			$data['logo']=$req->old_logo;
			
		}

        if($favicon){
			if(File::exists($req->old_favicon)){
				unlink($req->old_favicon);
			}
			$favicon_name=uniqid().'.'.strtolower($favicon->getClientOriginalExtension()); //unique nmae generate every time		    
            $upload_path='public/files/setting/';
			Image::make($favicon)->resize(32,32)->save($upload_path.$favicon_name); //image intervension package use

		    $data['favicon']=$upload_path.$favicon_name;
		}
		else{
			$data['favicon']=$req->old_favicon;
			
		}
        DB::table('website_settings')->where('id',$id)->update($data);
       $notification=array(
            'message'=>'setting updated!',
            'alert-type'=>'success',
        );

		return redirect()->back()->with($notification);
    }

   
    //__payment gateway
    public function PaymentGateway()
    {
        $aamarpay=DB::table('payment_gateway_bd')->first();
        $surjopay=DB::table('payment_gateway_bd')->skip(1)->first();
        $ssl=DB::table('payment_gateway_bd')->skip(2)->first();
        return view('admin.bdpayment_gateway.edit',compact('aamarpay','surjopay','ssl'));
    } 

    //__aamarpay update
    public function AamarpayUpdate(Request $request)
    {
        $data=array();
        $data['store_id']=$request->store_id;
        $data['signature_key']=$request->signature_key;
        $data['status']=$request->status;
        DB::table('payment_gateway_bd')->where('id',$request->id)->update($data);

        $notification=array(
            'message' => 'Payment Gateway Update Updated!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    //__update surjopay
    public function SurjopayUpdate(Request $request)
    {
        $data=array();
        $data['store_id']=$request->store_id;
        $data['signature_key']=$request->signature_key;
        $data['status']=$request->status;
        DB::table('payment_gateway_bd')->where('id',$request->id)->update($data);
        $notification=array('message' => 'Payment Gateway Update Updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
