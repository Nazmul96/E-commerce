<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
Use DataTables;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $req){
        if ($req->ajax()) {
    		$data=DB::table('warehouses')->latest()->get();

    		return DataTables::of($data)
    				->addIndexColumn()
    				->addColumn('action', function($row){

    					$actionbtn='<a href="#" class="btn btn-info btn-sm edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal" ><i class="fas fa-edit"></i></a>
                      	<a href="'.route('warehouse_delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                      	</a>';

                       return $actionbtn; 	

    				})
    				->rawColumns(['action'])
    				->make(true);		
    	}
	
    	return view('admin.category.warehouse.index');
    }

	//warehouse store......
	public function store(Request $req){

		$validatedData = $req->validate([
            'warehouse_name' => 'required|unique:warehouses',           
        ]);

		$data=array();
		$data['warehouse_name']=$req->warehouse_name;
		$data['warehouse_address']=$req->warehouse_address;
		$data['warehouse_phone']=$req->warehouse_phone;

		DB::table('warehouses')->insert($data);

		$notification=array(
            'message'=>'Warehouse Added!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

	//warehouse delete.....

	public function delete($id){
		DB::table('warehouses')->where('id',$id)->delete();
		$notification=array(
            'message'=>'Warehouse Deleted!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}

	//warehouse edit.....

	public function edit($id){

		$data=DB::table('warehouses')->where('id',$id)->first();

		return view('admin.category.warehouse.edit',compact('data'));
	}

	//warehouse update.....

	public function update(request $req,$id){
		$data=array();
		$data['warehouse_name']=$req->warehouse_name;
		$data['warehouse_address']=$req->warehouse_address;
		$data['warehouse_phone']=$req->warehouse_phone;

		DB::table('warehouses')->where('id',$id)->update($data);

		$notification=array(
            'message'=>'Warehouse Updated!',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
	}
}
