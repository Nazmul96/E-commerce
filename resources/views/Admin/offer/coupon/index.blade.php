@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Coupon</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">+ Add New</button>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">All Coupons list here</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped table-sm ytable">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Coupon Code</th>
                        <th>Coupon Amount</th>
                        <th>Coupon Date</th>
                        <th>Coupon Status</th>
                        <th>Action</th>                        
                      </tr>
                      </thead>
                      <tbody>
                    
                      </tbody>                     
                    </table>
                  </div>
            </div>
        </div>
    </div>
   </div>     
 </section>
</div>
{{--coupon insert modal--}} 
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('coupon_store')}}" method="POST">
      @csrf
      <div class="modal-body">
        
          <div class="form-group">
            <label for="coupon code">Coupon Code</label>
            <input type="text" class="form-control" name="coupon_code" required>
          </div>
          <div class="form-group">
            <label for="coupon type">Coupon Type</label>
            <select class="form-control" name="type" id="">
                  <option value="{{1}}">Fixed</option>
                  <option value="{{2}}">Percentage</option>
            </select>
          </div>
          <div class="form-group">
            <label for="coupon_amount">Coupon Amount </label>
            <input type="text" class="form-control"  name="coupon_amount" required="">
          </div>   
          <div class="form-group">
            <label for="valid_date">Coupon Date</label>
            <input type="date" class="form-control"  name="valid_date" required="">
          </div>

          <div class="form-group">
            <label for="coupon_code">Coupon Status </label>
            <select class="form-control" name="status" required>
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div> 
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="Submit" class="btn btn-primary"> <span class="d-none loader"><i class="fas fa-spinner"></i> Loading..</span> <span class="submit_btn"> Submit </span> </button>
      </div>
    </form>
    </div>
  </div>
</div> 
{{--coupon Edit--}} 
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Coupon</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal_body">

      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
	$(function coupon(){
		var table=$('.ytable').DataTable({
      processing: true,
      serverSide: true,
			ajax:"{{route('coupon_index')}}",
			columns:[
				{data:'DT_RowIndex',name:'DT_RowIndex'},
				{data:'coupon_code',name:'coupon_code'},
				{data:'coupon_amount',name:'coupon_amount'},
        {data:'valid_date',name:'valid_date'},
        {data:'status',name:'status'},
				{data:'action',name:'action',orderable:true, searchable:true},

			]
		});
	});

  $('body').on('click','.edit',function(){
      let coupon_id=$(this).data("id");
      $.get("coupon/edit/"+coupon_id,function(data){
          
         $("#modal_body").html(data);

      });
    });

</script>

@endsection