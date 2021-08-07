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

                      	<a href="'.route('coupon_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete_coupon"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action'])
    				->make(true);		
    	}
		
    	return view('admin.offer.coupon.index');
    }

	public function store(Request $req){
		Coupon::insert([
			'coupon_code'=>$req->coupon_code,
			'type'=>$req->type,
			'coupon_amount'=>$req->coupon_amount,
			'valid_date'=>$req->valid_date,
			'status'=>$req->status,
		]);
		return response()->json('Coupon inserted!');
	}
// edit coupon
	public function edit($id){
		$data=Coupon::find($id);
		return view('admin.offer.coupon.edit',compact('data'));
	}
// update coupon
	public function update(Request $req,$id){
		
		$data=array();
		$data['coupon_code']=$req->coupon_code;
		$data['type']=$req->type;
		$data['coupon_amount']=$req->coupon_amount;
		$data['valid_date']=$req->valid_date;
		$data['status']=$req->status;

		DB::table('coupons')->where('id',$id)->update($data);
		return response()->json('Coupon updated!');
	}


    // delete coupon

    public function delete($id)
    {
        DB::table('coupons')->where('id',$id)->delete();
        return response()->json('Coupon deleted!');
    }


}
