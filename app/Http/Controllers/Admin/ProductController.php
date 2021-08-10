<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //product create......
    public function create()
    {
        $data['categories']=DB::table('categories')->get();
        $data['brands']=DB::table('brands')->get();
        $data['pickup_points']=DB::table('pickup_point')->get();
        $data['warehouses']=DB::table('warehouses')->get();

        return view('admin.product.create',$data);
    }
}
