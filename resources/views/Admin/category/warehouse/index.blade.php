@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Warehouse</h1>
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
                  <h3 class="card-title">Warehouse list here</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped table-sm ytable">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Warehouse Name</th>
                        <th>Warehouse Address</th>
                        <th>Warehouse Phone</th>
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
{{--subcategory insert modal--}} 
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Warehouse</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('warehouse_store')}}" method="POST" id="add-form">
      @csrf
      <div class="modal-body">      
          <div class="form-group">
            <label for="warehouse_name">Warehouse Name</label>
            <input type="text" class="form-control" name="warehouse_name" placeholder="Warehouse Name" required>
          </div> 
           <div class="form-group">
            <label for="warehouse_address">Warehouse Address</label>
            <input type="text" class="form-control" name="warehouse_address" placeholder="Warehouse Address" required>
          </div> 
            <div class="form-group">
            <label for="warehouse_phone">Warehouse Phone</label>
            <input type="text" class="form-control" name="warehouse_phone" placeholder="Warehouse Phone" required>
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
{{--Category Edit--}} 
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Warehouse</h5>
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
	$(function warehouse(){
		var table=$('.ytable').DataTable({
      processing: true,
      serverSide: true,
			ajax:"{{route('warehouse_index')}}",
			columns:[
				{data:'DT_RowIndex',name:'DT_RowIndex'},
				{data:'warehouse_name'  ,name:'warehouse_name'},
				{data:'warehouse_address',name:'warehouse_address'},
				{data:'warehouse_phone',name:'warehouse_phone'},
				{data:'action',name:'action',orderable:true, searchable:true},

			]
		});
	});

  $('body').on('click','.edit',function(){
      let warehouse_id=$(this).data("id");
      $.get("warehouse/edit/"+warehouse_id,function(data){
          
         $("#modal_body").html(data);

      });
    });

    $('#add-form').on('submit',function(){
        $('.loader').removeClass('d-none');
        $('.submit-btn').addClass('d-none');
    });
</script>

@endsection