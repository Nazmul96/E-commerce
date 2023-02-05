<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
Use DataTables;
use Illuminate\Support\Str; //str helper function
use Image; //for image intervention package
use File;

class CampignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function imageUpload($request)
    {
        $photo=$request['image'];
        $slug=Str::slug($request['title'], '-'); //its only for image name
        $photoname=$slug.'.'.$photo->getClientOriginalExtension();
        Image::make($photo)->resize(468,90)->save('public/files/campaign/'.$photoname);  //image intervention 

        return $photoname;
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
    		$data=DB::table('campaigns')->get();
    		return DataTables::of($data)
    				->addIndexColumn()
                    ->editColumn('status',function($row){
                        if ($row->status==1) {
                            return '<a href="#"><span class="badge badge-success">Active</span> </a>';
                        }else{
                            return '<a href="#"><span class="badge badge-danger">Inactive</span> </a>';
                        }
                    })
    				->addColumn('action', function($row){
    					$actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                        <a href="'.route('campaign.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                        </a>
                        <a href="'.route('campaign.product',[$row->id]).'" class="btn btn-success btn-sm"><i class="fas fa-plus"></i>
                        </a>';
                       return $actionbtn; 	

    				})
                    ->rawColumns(['action','status'])
                    ->make(true); 		
    	}
		
    	return view('admin.offer.campaign.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|unique:campaigns|max:55',
            'start_date' => 'required',
            'image' => 'required',
            'discount' => 'required',
        ]);

        $data=array();
        $data['title']=$request->title;
        $data['start_date']=$request->start_date;
        $data['end_date']=$request->end_date;
        $data['status']=$request->status;
        $data['discount']=$request->discount;
        $data['month']=date('F');
        $data['year']=date('Y');
       
        //working with image
         $photoname=$this->imageUpload($request->all());
         $data['image']='public/files/campaign/'.$photoname;   // public/files/brand/plus-point.jpg
         DB::table('campaigns')->insert($data);

         $notification=array(
            'message'=>'Campaign Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
    }


    public function delete($id)
    {
        $data=DB::table('campaigns')->where('id',$id)->first();
        $image=$data->image;
        if (File::exists($image)) {
             unlink($image);
        }
        DB::table('campaigns')->where('id',$id)->delete();
        $notification=array(
            'message'=>'Campaign Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification); 
    }

    public function edit($id)
    {
        $data=DB::table('campaigns')->where('id',$id)->first();
        return view('admin.offer.campaign.edit',compact('data'));
    }

    public function update(Request $request)
    {
        $slug=Str::slug($request->title, '-');
        $data=array();
        $data['title']=$request->title;
        $data['start_date']=$request->start_date;
        $data['end_date']=$request->end_date;
        $data['status']=$request->status;
        $data['discount']=$request->discount;

        if ($request->image) {
              if (File::exists($request->old_image)) {
                     unlink($request->old_image);
                }
              $photoname=$this->imageUpload($request->all());
              $data['image']='public/files/campaign/'.$photoname; 
        }

        DB::table('campaigns')->where('id',$request->id)->update($data); 
        $notification=array(
            'message'=>'Campaign Updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }

}
