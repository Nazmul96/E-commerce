<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;
use Illuminate\Support\Str;
use Image;
use File;


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
            'icon' => 'required',          
        ]);

        $photo=$num->icon;
        $photoname=$num->category_name.'.'.$photo->getClientOriginalExtension();
        Image::make($photo)->resize(32,32)->save('public/files/category/'.$photoname);

        //Eloquent Orm
        
        Category::insert([
            'category_name'=>$num->category_name,
            'category_slug'=>Str::slug($num->category_name, '-'),
            'home_page'=> $num->home_page,
            'icon'=> 'public/files/category/'.$photoname,
        ]);   

        $notification=array(
            'message'=>'Category Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);       
    }

    //Category edit method.....
    public function edit($id) {
        
        $data=Category::findorfail($id);
        return view('admin.category.category.edit',compact('data'));
    }

    //Category update method.....
    public function update(Request $request){
        $validatedData = $request->validate([
            'category_name' => 'required',           
        ]);
        $slug=Str::slug($request->category_name, '-');
        $data=array();
        $data['category_name']=$request->category_name;
        $data['category_slug']=$slug;
        $data['home_page']=$request->home_page;

        if ($request->icon) {
            if (File::exists($request->old_icon)) {
                   unlink($request->old_icon);
              }
            $photo=$request->icon;
            $photoname=$slug.'.'.$photo->getClientOriginalExtension();
            Image::make($photo)->resize(32,32)->save('public/files/category/'.$photoname); 
            $data['icon']='public/files/category/'.$photoname;  
        }

        DB::table('categories')->where('id',$request->id)->update($data); 

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
