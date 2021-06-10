<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use DB;
Use DataTables;


class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        if ($request->ajax()){
            $data=Coupon::all();
    		return DataTables::of($data)
    				->addIndexColumn()
    				->addColumn('action', function($row){

    					$actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                      	<a href="'.route('coupon_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action'])
    				->make(true);		
    	}
		
    	return view('admin.coupon.index');
    }

	public function store(Request $req){
		Coupon::insert([
			'coupon'=>$req->coupon_code,
			'discount'=>$req->coupon_discount,
		]);
		$notification=array(
            'message'=>'Coupon Inserted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

	public function delete($id){
		$delete=Coupon::find($id);
		$delete->delete();
		$notification=array(
            'message'=>'Coupon Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

	public function edit($id){
		$data=Coupon::find($id);
		return view('admin.coupon.edit',compact('data'));
	}

	public function update(Request $req,$id){
		$coupon=Coupon::find($id);
		$coupon->update([
			'coupon'=>$req->coupon_code,
			'discount'=>$req->coupon_discount,
		]);
		$notification=array(
            'message'=>'Coupon updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}
}
