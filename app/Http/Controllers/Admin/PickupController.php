<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
Use DataTables;

class PickupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req){
        if ($req->ajax()){
            $data=DB::table('pickup_point')->latest()->get();
    		return DataTables::of($data)
    				->addIndexColumn()
    				->addColumn('action', function($row){

    					$actionbtn='<a href="'.route('pickup_point_edit',[$row->id]).'" class="btn btn-info btn-sm" data-id="" data-toggle="" data-target="" ><i class="fas fa-edit"></i></a>
                      	<a href="'.route('pickup_point_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action'])
    				->make(true);		
    	}
		
    	return view('admin.pickup_point.index');
    }

    public function store(Request $req){
		$data=array();
		$data['pickup_point_name']=$req->pickup_point_name;
		$data['pickup_point_address']=$req->pickup_point_address;
		$data['pickup_point_phone']=$req->pickup_point_phone;
		$data['pickup_point_phone_two']=$req->pickup_point_phone_two;
		
		DB::table('pickup_point')->insert($data);
		$notification=array(
            'message'=>'Successfully Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

	public function delete($id){
		$data=DB::table('pickup_point')->where('id',$id)->delete();
		$notification=array(
            'message'=>'Successfully Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

    public function edit($id){
		$data=DB::table('pickup_point')->where('id',$id)->first();
		return view('admin.pickup_point.edit',compact('data'));
	}

	public function update(Request $req,$id){
		
		$data=array();
		$data['pickup_point_name']=$req->pickup_point_name;
		$data['pickup_point_address']=$req->pickup_point_address;
		$data['pickup_point_phone']=$req->pickup_point_phone;
		$data['pickup_point_phone_two']=$req->pickup_point_phone_two;

		DB::table('pickup_point')->where('id',$id)->update($data);

		$notification=array(
            'message'=>'Picup-Point updated!',
            'alert-type'=>'success',
        );
        return redirect()->route('pickup_point_index')->with($notification);
	}
}
