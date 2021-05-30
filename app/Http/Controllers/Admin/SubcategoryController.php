<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Subcategory;
use DB;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //index method for read data......
    //Query Builder one to one join.....

    public function index(){
        $data=DB::table('subcategories')
             ->join('categories','subcategories.category_id','categories.id')
             ->select('subcategories.*','categories.category_name')->get();

        $category=DB::table('categories')->get();     
        return view('Admin.category.subcategory.index',compact('data','category'));
    }
   
    //store method for insert data in subcategory..... 

    public function store(Request $num){
        $validatedData = $num->validate([
            'subcategory_name' => 'required|max:55',           
        ]);
        $data=array(); //Query Builder
        $data['category_id']=$num->category_id;
        $data['subcat_name']=$num->subcategory_name;
        $data['subcat_slug']=Str::slug($num->subcategory_name, '-');
        DB::table('subcategories')->insert($data);

        $notification=array(
            'message'=>'subcategory Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
    }

    //delete subcategory....

    public function delete($id){
        DB::table('subcategories')->where('id',$id)->delete();
        $notification=array(
            'message'=>'subcategory Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }

    //edit subcategory......

    public function edit($id){
        //Eloquent ORM
        //$category=Category::all();
        //$data=Subcategory::find($id);
        
        //Query Builder.....
        $category=DB::table('categories')->get();
        $data=DB::table('subcategories')->where('id',$id)->first();

        return view('Admin.category.subcategory.edit',compact('data','category'));
    }

    //update subcategory.....

    public function update(Request $num,$id){
        $validatedData = $num->validate([
            'subcategory_name' => 'required|max:55',           
        ]);
        //$data=array(); //Query Builder
        //$data['category_id']=$num->category_id;
        //$data['subcat_name']=$num->subcategory_name;
        //$data['subcat_slug']=Str::slug($num->subcategory_name, '-');
        //DB::table('subcategories')->where('id',$num->id)->update($data);

        //Eloquent ORM....
        $subcat=Subcategory::find($id);
        $subcat->update([
            'category_id'=>$num->category_id,
            'subcat_name'=>$num->subcategory_name,
            'subcat_slug'=>Str::slug($num->subcategory_name, '-'),
        ]);
        $notification=array(
            'message'=>'subcategory Updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
    }
}
