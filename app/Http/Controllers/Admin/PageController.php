<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //All Page Show Method.....

    public function index(){

        $data=DB::table('pages')->get();
        return view('admin.setting.page.index',compact('data'));
    }

    //Page Create Method......
    public function create(){
        return view('admin.setting.page.create');
    }

    //page store......

    public function store(Request $req){
        $data=array();
        $data['page_position']=$req->page_position;
        $data['page_name']=$req->page_name;
        $data['page_slug']=Str::slug($req->page_name,'-');
        $data['page_title']=$req->page_title;
        $data['page_description']=$req->page_description;

        DB::table('pages')->insert($data);

        $notification=array(
            'message'=>'Page Created!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 

    }

    //page delete......

    public function pagedelete($id){
        DB::table('pages')->where('id',$id)->delete();
        $notification=array(
            'message'=>'Page Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }

    //page edit.......
    public function page_edit($id){
        $page=DB::table('pages')->where('id',$id)->first();
        return view('admin.setting.page.edit',compact('page'));
    }

    //page update......
    public function page_update(Request $req,$id){
        $data=array();
        $data['page_position']=$req->page_position;
        $data['page_name']=$req->page_name;
        $data['page_slug']=Str::slug($req->page_name,'-');
        $data['page_title']=$req->page_title;
        $data['page_description']=$req->page_description;

        DB::table('pages')->where('id',$id)->update($data);

        $notification=array(
            'message'=>'Page Updated!',
            'alert-type'=>'success',
        );
        return redirect()->route('page_index')->with($notification); 
    }
}
