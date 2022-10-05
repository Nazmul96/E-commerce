<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //All Category Showing method.....

    public function index(){
        $data=DB::table('categories')->get();//query builder
        //$data=Category::all(); //Eluquent ORM
        return view('admin.category.category.index',compact('data'));
    }

    //Category Store method.....
    public function store(Request $num){
        $validatedData = $num->validate([
            'category_name' => 'required|unique:categories|max:55',           
        ]);
        //$data=array(); //Query Builder
        //$data['category_name']=$num->category_name;
        //$data['category_slug']=Str::slug($num->category_name, '-');
        //DB::table('categories')->insert($data);

        //Eloquent Orm
        
        Category::insert([
            'category_name'=>$num->category_name,
            'category_slug'=>Str::slug($num->category_name, '-')
        ]);    
        $notification=array(
            'message'=>'Category Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);       
    }

    //Category edit method.....
    public function edit($id) {
    //$data=DB::table('categories')->where('id',$id)->first(); //Query Builder
    $data=Category::findorfail($id);
    return response()->json($data);
    }

    //Category update method.....
    public function update(Request $num){
        $validatedData = $num->validate([
            'category_name' => 'required|unique:categories|max:55',           
        ]);
        //$data=array();   //Query Builder......
        //$data['category_name']=$num->category_name;
        //$data['category_slug']=Str::slug($num->category_name, '-');
        //DB::table('categories')->where('id',$num->id)->update($data);

        //Eloquent ORM.....
        $category=Category::find($num->id);
        $category->update([
            'category_name'=>$num->category_name,
            'category_slug'=>Str::slug($num->category_name, '-')
        ]);
        $notification=array(
            'message'=>'Category Updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
    }


    //Category Delete method.....
    public function delete($id){
        //$data=DB::table('categories')->where('id',$id)->delete();

        //Eloquent ORM
        $delete=Category::find($id);//here 'find' use for only one row data catching                     //also can use findorfail()
        $delete->delete();          
        $notification=array(
            'message'=>'Category Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }

    
	//get child category
    public function GetChildCategory($id)  //subcategory_id
    {
        $data=DB::table('childcategories')->where('subcategory_id',$id)->get();
         return response()->json($data);
        
    }

}
