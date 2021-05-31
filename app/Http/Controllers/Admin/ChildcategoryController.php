<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
Use DataTables;
use Illuminate\Support\Str;

class ChildcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
	//index method for read childcategory data......
    //Query Builder one to one join.....

    public function index(Request $request)
    {
    	if ($request->ajax()) {
    		$data=DB::table('childcategories')->leftJoin('categories','childcategories.category_id','categories.id')->leftJoin('subcategories','childcategories.subcategory_id','subcategories.id')
    		->select('categories.category_name','subcategories.subcat_name','childcategories.*')->get();

    		return DataTables::of($data)
    				->addIndexColumn()
    				->addColumn('action', function($row){

    					$actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                      	<a href="'.route('childcategory_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action'])
    				->make(true);		
    	}
		$category=DB::table('categories')->get();
    	return view('admin.category.childcategory.index',compact('category'));
    }

	//childcategory store.....
	public function store(Request $req){
		$validatedData = $req->validate([
            'childcategory_name' => 'required|unique:childcategories|max:55',           
        ]);
		$cat_id=DB::table('subcategories')->where('id',$req->subcategory_id)->first();
		$data=array();
		$data['category_id']=$cat_id->category_id;
		$data['subcategory_id']=$req->subcategory_id;
		$data['childcategory_name']=$req->childcategory_name;
		$data['childcategory_slug']=Str::slug($req->childcategory_name, '-');

		DB::table('childcategories')->insert($data);

		$notification=array(
            'message'=>'Child-category Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

	//childcategory delete.....
	public function delete($id){
		$data=DB::table('childcategories')->where('id',$id)->delete();
		$notification=array(
            'message'=>'Child-category Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
	}
	//childcategory edit.....
	public function edit($id)
    {
        $category=DB::table('categories')->get();
        $data=DB::table('childcategories')->where('id',$id)->first();
        return view('admin.category.childcategory.edit',compact('category','data'));
    }
	//childcategory update.....
    public function update(Request $req,$id)
    {    
		$cat_id=DB::table('subcategories')->where('id',$req->subcategory_id)->first();
		$data=array();
		$data['category_id']=$cat_id->category_id;
		$data['subcategory_id']=$req->subcategory_id;
		$data['childcategory_name']=$req->childcategory_name;
		$data['childcategory_slug']=Str::slug($req->childcategory_name, '-');

		DB::table('childcategories')->where('id',$id)->Update($data);

		$notification=array(
            'message'=>'Child-category updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
       
    }

}