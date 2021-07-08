@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Pickup Point</h1>
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
                  <h3 class="card-title">Pickup Point list</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped table-sm ytable">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Pickup Point</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Another Phone</th>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Add Pickup Point</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('pickup_point_store')}}" method="POST" id="add_form">
        @csrf
    <div class="modal-body">
        <div class="form-group">
          <label for="pickup_point_name">Pickup Point Name <span class="text-danger">*</span> </label>
          <input type="text" class="form-control"  name="pickup_point_name" required="">
        </div>     
        <div class="form-group">
          <label for="pickup_point_address">Address <span class="text-danger">*</span></label>
          <input type="text" class="form-control"  name="pickup_point_address" required="">
        </div>
        <div class="form-group">
          <label for="pickup_point_phone">Phone <span class="text-danger">*</span></label>
          <input type="text" class="form-control"  name="pickup_point_phone" required="">
        </div>
        <div class="form-group">
          <label for="pickup_point_phone_two">Another Phone </label>
          <input type="text" class="form-control"  name="pickup_point_phone_two" >
        </div>   
    <div class="modal-footer">
      <button type="Submit" class="btn btn-primary"> <span class="loading d-none"> Loading....</span> Submit</button>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Pickup Point</h5>
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
			ajax:"{{route('pickup_point_index')}}",
			columns:[
				{data:'DT_RowIndex',name:'DT_RowIndex'},
				{data:'pickup_point_name',name:'pickup_point_name'},
				{data:'pickup_point_address',name:'pickup_point_address'},
        {data:'pickup_point_phone',name:'pickup_point_phone'},
        {data:'pickup_point_phone_two',name:'pickup_point_phone_two'},
				{data:'action',name:'action',orderable:true, searchable:true},

			]
		});
	});

  $('body').on('click','.edit',function(){
      let pickup_id=$(this).data("id");
      $.get("pickup-point/edit/"+pickup_id,function(data){
          
         $("#modal_body").html(data);

      });
    });

    $('#add-form').on('submit',function(){
        $('.loader').removeClass('d-none');
        $('.submit-btn').addClass('d-none');
    });

</script>

@endsection
