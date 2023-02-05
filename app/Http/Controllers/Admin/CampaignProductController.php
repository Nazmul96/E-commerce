<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CampaignProductController extends Controller
{
    
       //__campaign products all method__//
       public function campaignProduct($campaign_id)
       {
              $products=DB::table('products')->leftJoin('categories','products.category_id','categories.id')
                       ->leftJoin('subcategories','products.subcategory_id','subcategories.id')
                       ->leftJoin('brands','products.brand_id','brands.id')
                       ->select('products.*','categories.category_name','subcategories.subcat_name','brands.brand_name')
                       ->where('products.status','1')
                       ->get();

               return view('admin.offer.campaign_product.index',compact('products','campaign_id'));
       }

        //__add product to campaign__//
    public function ProductAddToCampaign($product_id,$campaign_id)
    {
       
       $campaign=DB::table('campaigns')->where('id',$campaign_id)->first();
       $product=DB::table('products')->where('id',$product_id)->first();
    
       if(is_null($product->discount_price))
       {
        $discount_amount=$product->selling_price/100*$campaign->discount;
        $discount_price=$product->selling_price-$discount_amount;
       }
       else
       {
        $discount_amount=$product->discount_price/100*$campaign->discount;
        $discount_price=$product->discount_price-$discount_amount;
       }

       $data=array();
       $data['product_id']=$product_id;
       $data['campaign_id']=$campaign_id;
       $data['price']=$discount_price;
       DB::table('campaign_products')->insert($data);
       $notification=array('messege' => 'Product added to campaign!', 'alert-type' => 'success');
       return redirect()->back()->with($notification);
    }

    //__product list__//
    public function ProductListCampaign($campaign_id)
    {
        $products=DB::table('campaign_products')->leftJoin('products','campaign_products.product_id','products.id')
                    ->select('products.name','products.code','products.thumbnail','campaign_products.*')
                    ->where('campaign_products.campaign_id',$campaign_id)
                    ->get();
        $campaign=DB::table('campaigns')->where('id',$campaign_id)->first();            
        return view('admin.offer.campaign_product.campaign_product_list',compact('products','campaign'));
    }

    //__product rmove from campaign__//
    public function RemoveProduct($id)
    {
        DB::table('campaign_products')->where('id',$id)->delete();
        $notification=array('messege' => 'Product remove from campaign!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
