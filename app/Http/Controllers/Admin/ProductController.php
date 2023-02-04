<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Image;
Use DataTables;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $imgurl='public/files/product';
            
            $product="";
              $query=DB::table('products')->leftJoin('categories','products.category_id','categories.id')
                    ->leftJoin('subcategories','products.subcategory_id','subcategories.id')
                    ->leftJoin('brands','products.brand_id','brands.id');
            
            if ($request->category_id) {
                $query->where('products.category_id',$request->category_id);
            }

            if ($request->brand_id) {
                $query->where('products.brand_id',$request->brand_id);
            }

            if ($request->warehouse) {
                $query->where('products.warehouse',$request->warehouse);
            }

            // if ($request->status_new==1) {
            //     $query->where('products.status',1);
            // }
            // if ($request->status_new==0) {
            //     $query->where('products.status',0);
            // }

            $product=$query->select('products.*','categories.category_name','subcategories.subcat_name','brands.brand_name')->get();

    		return DataTables::of($product)
    				->addIndexColumn()
                    ->editColumn('thumbnail',function($row) use($imgurl){
                        return '<img src="'.$imgurl.'/'.$row->thumbnail.'" height="30" weight="30">';
                    })
                    // ->editColumn('category_name',function($row){
                    //     return $row->category->category_name;
                    // })
                    // ->editColumn('subcategory_name',function($row){
                    //     return $row->subcategory->subcat_name;
                    // })
                    // ->editColumn('brand_name',function($row){
                    //     return $row->brand->brand_name;
                    // })
                    ->editColumn('featured',function($row){
                        if($row->featured==1){
                            return '<a href="#"  data-id="'.$row->id.'" class="deactive_featured"><i class="fas fa-thumbs-down text-danger"></i><span class="badge badge-success">Active</span></a>';
                        }
                        else{
                            return '<a href="#" data-id="'.$row->id.'" class="active_featured"><i class="fas fa-thumbs-up text-success"></i><span class="badge badge-danger">Deactive</span></a>';
                        }
                    })
                    ->editColumn('today_deal',function($row){
                        if($row->today_deal==1){
                            return '<a href="#" data-id="'.$row->id.'" class="deactive_todaydeal"><i class="fas fa-thumbs-down text-danger"></i><span class="badge badge-success">Active</span></a>';
                        }
                        else{
                            return '<a href="#" data-id="'.$row->id.'" class="active_todaydeal"><i class="fas fa-thumbs-up text-success"></i><span class="badge badge-danger">Deactive</span></a>';
                        }
                    })
                    ->editColumn('status',function($row){
                        if($row->status==1){
                            return '<a href="#" data-id="'.$row->id.'" class="deactive_status"><i class="fas fa-thumbs-down text-danger"></i><span class="badge badge-success">Active</span></a>';
                        }
                        else{
                            return '<a href="#" data-id="'.$row->id.'" class="active_status"><i class="fas fa-thumbs-up text-success"></i><span class="badge badge-danger">Deactive</span></a>';
                        }
                    })
    				->addColumn('action', function($row){
    					$actionbtn='<a href="'.route('product.edit',[$row->id]).'" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-info btn-sm edit"><i class="fas fa-eye"></i></a>
                      	<a href="'.route('product_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action','category_name','subcategory_name','brand_name','thumbnail','featured','today_deal','status'])
    				->make(true);		
    	}
		$category=DB::table('categories')->get();
        $brand=DB::table('brands')->get();
        $warehouse=DB::table('warehouses')->get();
    	return view('admin.product.index',compact('category','brand','warehouse'));
    }
    //product create......
    public function create()
    {
        $data['categories']=DB::table('categories')->get();
        $data['brands']=DB::table('brands')->get();
        $data['pickup_points']=DB::table('pickup_point')->get();
        $data['warehouses']=DB::table('warehouses')->get();

        return view('admin.product.create',$data);
    }

    //product store......

    public function store(Request $req)
    {
        $validatedData = $req->validate([
            'name'=>'required',
            'code' => 'required|unique:products|max:55',
            'subcategory_id'=>'required',
            'brand_id'=>'required',
            'unit'=>'required',
            'selling_price'=>'required',
            'color'=>'required',
            'description'=>'required',           
        ]);

        //Find category_id by subcategory_id
        $subcategory=DB::table('subcategories')->where('id',$req->subcategory_id)->first();
        $slug=Str::slug($req->name, '-');

        $data=array();
        $data['name']=$req->name;
        $data['slug']=Str::slug($req->name, '-');
        $data['code']=$req->code;
        $data['category_id']=$subcategory->category_id;
        $data['subcategory_id']=$req->subcategory_id;
        $data['childcategory_id']=$req->childcategory_id;
        $data['brand_id']=$req->brand_id;
        $data['pickup_point_id']=$req->pickup_point_id;
        $data['unit']=$req->unit;
        $data['tags']=$req->tags;
        $data['purchase_price']=$req->purchase_price;
        $data['selling_price']=$req->selling_price;
        $data['discount_price']=$req->discount_price;
        $data['warehouse']=$req->warehouse;
        $data['stock_quantity']=$req->stock_quantity;
        $data['color']=$req->color;
        $data['size']=$req->size;
        $data['description']=$req->description;
        $data['video']=$req->video;
        $data['featured']=$req->featured;
        $data['today_deal']=$req->today_deal;
        $data['status']=$req->status;
        $data['trendy_product']=$req->trendy_product;
        $data['product_slider']=$req->product_slider;
        $data['admin_id']=Auth::id();
        $data['date']=date('d-m-Y');
        $data['month']=date('F');
        
        
        //single thumbnail
        if ($req->thumbnail) {
        $thumbnail=$req->thumbnail;
        $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
        Image::make($thumbnail)->resize(600,600)->save('public/files/product/'.$photoname);
        $data['thumbnail']=$photoname;   // public/files/product/plus-point.jpg
        }

       //multiple images
       $images = array();
       if($req->hasFile('images')){
           foreach ($req->file('images') as $key => $image) {
               $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
               Image::make($image)->resize(600,600)->save('public/files/product/'.$imageName);
               array_push($images, $imageName);
           }
           $data['images'] = json_encode($images);
       }

       DB::table('products')->insert($data);

       $notification=array(
        'message'=>'Product Inserted!',
        'alert-type'=>'success',
       ); 
      return redirect()->route('product_index')->with($notification);

    }

    //Product delete------------
    public function product_delete($id)
    {
        DB::table('products')->where('id',$id)->delete();
        $notification=array(
            'message'=>'Product Deleted!',
            'alert-type'=>'success',
           );
        return redirect()->back()->with($notification);  
    }

    //Featured Deactive........
    public function featured_deactive($id){
        DB::table('products')->where('id',$id)->update(['featured'=>0]);
        return response()->json('Product featured deactivated');
    }

    //Featured Active........
    public function featured_active($id){
        DB::table('products')->where('id',$id)->update(['featured'=>1]);
        return response()->json('Product featured activated');
    }


    //Today_deal Deactive........
    public function todaydeal_deactive($id){
        DB::table('products')->where('id',$id)->update(['today_deal'=>0]);
        return response()->json('Today Deal deactivated');
    }

    //Today_deal active........
    public function todaydeal_active($id){
        DB::table('products')->where('id',$id)->update(['today_deal'=>1]);
        return response()->json('Today Deal activated');
    }

    //Status Deactive........
    public function status_deactive($id){
        DB::table('products')->where('id',$id)->update(['status'=>0]);
        return response()->json('Status deactivated');
    }

    //Status active........
    public function status_active($id){
        DB::table('products')->where('id',$id)->update(['status'=>1]);
        return response()->json('Status activated');
    }
    
    //edit method
    public function edit($id)
    {
        $product=DB::table('products')->where('id',$id)->first();
        //$product=Product::findorfail($id);
        $category=Category::all();
        $brand=Brand::all();
        $warehouse=DB::table('warehouses')->get();
        $pickup_point=DB::table('pickup_point')->get();
        //childcategory get_
        $childcategory=DB::table('childcategories')->where('category_id',$product->category_id)->get();
        // dd($childcategory);
        return view('admin.product.edit',compact('product','category','brand','warehouse','pickup_point','childcategory'));
    }

    //__update product__//
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|max:55',
            'subcategory_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'selling_price' => 'required',
            'color' => 'required',
            'description' => 'required',
        ]);

        //subcategory call for category id
        $subcategory=DB::table('subcategories')->where('id',$request->subcategory_id)->first();
        $slug=Str::slug($request->name,'-');


        $data=array();
        $data['name']=$request->name;
        $data['slug']=Str::slug($request->name, '-');
        $data['code']=$request->code;
        $data['category_id']=$subcategory->category_id;
        $data['subcategory_id']=$request->subcategory_id;
        $data['childcategory_id']=$request->childcategory_id;
        $data['brand_id']=$request->brand_id;
        $data['pickup_point_id']=$request->pickup_point_id;
        $data['unit']=$request->unit;
        $data['tags']=$request->tags;
        $data['purchase_price']=$request->purchase_price;
        $data['selling_price']=$request->selling_price;
        $data['discount_price']=$request->discount_price;
        $data['warehouse']=$request->warehouse;
        $data['stock_quantity']=$request->stock_quantity;
        $data['color']=$request->color;
        $data['size']=$request->size;
        $data['description']=$request->description;
        $data['video']=$request->video;
        $data['featured']=$request->featured;
        $data['today_deal']=$request->today_deal;
        $data['product_slider']=$request->product_slider;
        $data['status']=$request->status;
        $data['trendy_product']=$request->trendy;

        //__old thumbnail ase kina__ jodi thake new thumbnail insert korte hobe
        $thumbnail = $request->file('thumbnail');
        if($thumbnail) {
            
                $thumbnail=$request->thumbnail;
                $photoname=$slug.'.'.$thumbnail->getClientOriginalExtension();
                Image::make($thumbnail)->resize(600,600)->save('public/files/product/'.$photoname);
                $data['thumbnail']=$photoname;   // public/files/product/plus-point.jpg   
        }

        //__multiple image update__//

        $old_images = $request->has('old_images');
        if($old_images){
            $images = $request->old_images;
            $data['images'] = json_encode($images);
        }else{
            $images = array();
            $data['images'] = json_encode($images); 
        }

        if($request->hasFile('images')){
            foreach ($request->file('images') as $key => $image) {
                $imageName= hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
                Image::make($image)->resize(600,600)->save('public/files/product/'.$imageName);
                array_push($images, $imageName);
            }
            $data['images'] = json_encode($images);
        }



        DB::table('products')->where('id',$request->id)->update($data);
        $notification=array('messege' => 'Product Updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
