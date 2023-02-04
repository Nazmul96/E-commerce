<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use DB;
use App\Mail\RecievedMail;
use Mail;

class ReportController extends Controller
{
    public function ReportOrderindex(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $imgurl='public/files/product';
            $product="";
              $query=DB::table('orders')->orderBy('id','DESC');
                if (!is_null($request->payment_type)) {
                    $query->where('payment_type',$request->payment_type);
                }

                if (!is_null($request->date)) {
                    $order_date=date('d-m-Y',strtotime($request->date));
                    $query->where('date',$order_date);
                }

                if ((!is_null($request->status))&&($request->status == 0)) {
                    $query->where('status',0);
                }
                if ((!is_null($request->status))&&($request->status == 1)) {
                    $query->where('status',1);
                }
                if ((!is_null($request->status))&&($request->status == 2)) {
                    $query->where('status',2);
                }
                if ((!is_null($request->status))&&($request->status == 3)) {
                    $query->where('status',3);
                }
                if ((!is_null($request->status))&&($request->status == 4)) {
                    $query->where('status',4);
                }
                if ((!is_null($request->status))&&($request->status == 5)) {
                    $query->where('status',5);
                }
               

            $product=$query->get();
            return DataTables::of($product)
                    ->addIndexColumn()
                    ->editColumn('status',function($row){
                        if ($row->status==0) {
                            return '<span class="badge badge-danger">Pending</span>';
                        }elseif($row->status==1){
                            return '<span class="badge badge-primary">Recieved</span>';
                        }elseif($row->status==2){
                            return '<span class="badge badge-info">Shipped</span>';
                        }elseif($row->status==3){
                            return '<span class="badge badge-success">Completed</span>';
                        }elseif($row->status==4){
                            return '<span class="badge badge-warning">Return</span>';
                        }elseif($row->status==5){
                            return '<span class="badge badge-danger">Cancel</span>';
                        }
                    })
                    ->addColumn('action', function($row){
                        $actionbtn='
                        <a href="#" data-id="'.$row->id.'" class="btn btn-primary btn-sm view" data-toggle="modal" data-target="#viewModal"><i class="fas fa-eye"></i></a>
                        <a href="#" data-id="'.$row->id.'" class="btn btn-info btn-sm edit" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a> 
                        <a href="'.route('order.delete',[$row->id]).'" class="btn btn-danger btn-sm" id="delete"><i class="fas fa-trash"></i>
                        </a>';
                       return $actionbtn;   
                    })
                    ->rawColumns(['status'])
                    ->make(true);       
        }
        return view('admin.report.order.index');
    }

    //order print__
    public function ReportOrderPrint(Request $request)
    {
        if ($request->ajax()) {
            $order="";
                $query=DB::table('orders')->orderBy('id','DESC');
                if ($request->payment_type) {
                    $query->where('payment_type',$request->payment_type);
                }

                if ($request->date) {
                    $order_date=date('d-m-Y',strtotime($request->date));
                    $query->where('date',$order_date);
                }

                if ($request->status==0) {
                    $query->where('status',0);
                }
                if ($request->status==1) {
                    $query->where('status',1);
                }
                if ($request->status==2) {
                    $query->where('status',2);
                }
                if ($request->status==3) {
                    $query->where('status',3);
                }
                if ($request->status==4) {
                    $query->where('status',4);
                }
                if ($request->status==5) {
                    $query->where('status',5);
                }     
            $order=$query->get();
        }

        return view('admin.report.order.print',compact('order'));
    }

    
}
