<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
Use DataTables;
use Illuminate\Support\Str; //str helper function
use Image; //for image intervention package
use File;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	// index method for show brand......
    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data=DB::table('brands')->get();

    		return DataTables::of($data)
    				->addIndexColumn()
    				->addColumn('action', function($row){

    					$actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                      	<a href="'.route('brand_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action'])
    				->make(true);		
    	}
		
    	return view('admin.category.brand.index');
    }

	// store brand....
	public function store(Request $req){
		$validatedData = $req->validate([
            'brand_name' => 'required|unique:brands|max:55',           
        ]);

		$data=array();
		$data['brand_name']=$req->brand_name;
		$data['brand_slug']=str::slug($req->brand_name,'-');
		//working with Image
		$image=$req->brand_logo;
		// echo $image;
		// die();
		$image_name=str::slug($req->brand_name,'-'); //unique nmae generate every time
		$ext=strtolower($image->getClientOriginalExtension());
		$image_full_name=$image_name.'.'.$ext;
		$upload_path='public/files/brand/';
		//$success=$image->move($upload_path,$image_full_name);//without image intervention
		Image::make($image)->resize(240,120)->save('public/files/brand/'.$image_full_name); //image intervension package use

		$data['brand_logo']=$upload_path.$image_full_name;
		DB::table('brands')->insert($data);

		$notification=array(
            'message'=>'Brand Inserted!',
            'alert-type'=>'success',
        );

		return redirect()->back()->with($notification);
	}
	//Delete Brand.....
	public function delete($id){

		$data=DB::table('brands')->where('id',$id)->first();
		$image=$data->brand_logo;
		if(File::exists($image)){
			unlink($image);
		}
		DB::table('brands')->where('id',$id)->delete();
		$notification=array(
            'message'=>'Brand deleted!',
            'alert-type'=>'success',
        );
		return redirect()->back()->with($notification);
	}

	//edit brand.....
	public function edit($id){
		$data=DB::table('brands')->where('id',$id)->first();

		return view('admin.category.brand.edit',compact('data'));
	}

	//Update brand....
	public function update(Request $req,$id){
		$validatedData = $req->validate([
            'brand_name' => 'required|unique:brands|max:55',           
        ]);
		$data=array();
		$data['brand_name']=$req->brand_name;
		$data['brand_slug']=str::slug($req->brand_name,'-');
		$image=$req->brand_logo;
		if($image){
			if(File::exists($req->old_logo)){
				unlink($req->old_logo);
			}
			$image_name=str::slug($req->brand_name,'-'); //unique nmae generate every time
		    $ext=strtolower($image->getClientOriginalExtension());
		    $image_full_name=$image_name.'.'.$ext;
		    $upload_path='public/files/brand/';
			Image::make($image)->resize(240,120)->save('public/files/brand/'.$image_full_name); //image intervension package use

		    $data['brand_logo']=$upload_path.$image_full_name;
		    DB::table('brands')->where('id',$id)->update($data);
			$notification=array(
				'message'=>'Brand Updated!',
				'alert-type'=>'success',
			);
	
			return redirect()->back()->with($notification);
		}
		else{
			$data['brand_logo']=$req->old_logo;
			DB::table('brands')->where('id',$id)->update($data);
			$notification=array(
				'message'=>'Brand Updated!',
				'alert-type'=>'success',
			);
	
			return redirect()->back()->with($notification);	
		}
	}
}
