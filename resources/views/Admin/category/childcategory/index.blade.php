@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Child Category</h1>
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
                  <h3 class="card-title">All Child-Categories list here</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="" class="table table-bordered table-striped table-sm ytable">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Child Category Name</th>
                        <th>Category Name</th>
                        <th>Sub Category Name</th>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Child Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('childcategory_store')}}" method="POST">
      @csrf
      <div class="modal-body">
           
        <div class="form-group">
          <label for="category_name">Category/Subcategory Name</label>
          <select class="form-control" name="subcategory_id" required>
            @foreach ($category as $row)
            <option>{{$row->category_name}}</option>
            @php
                $subcategory=DB::table('subcategories')->where('category_id',$row->id)->get();
            @endphp           
            @foreach ($subcategory as $sub)
            <option value="{{$sub->id}}">---- {{$sub->subcat_name}}</option>
            @endforeach
           @endforeach 
          </select>
        </div> 
        
          <div class="form-group">
            <label for="subcategory_name">Child-category Name</label>
            <input type="text" class="form-control" name="childcategory_name" required>
            <small id="emailHelp" class="form-text text-muted">This is your main Childcategory</small>
          </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary"><span class="d-none">loading......</span>Submit</button>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Child-Category</h5>
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
	$(function childcategory(){
		var table=$('.ytable').DataTable({
      processing: true,
      serverSide: true,
			ajax:"{{ route('childcat_index') }}",
			columns:[
				{data:'DT_RowIndex',name:'DT_RowIndex'},
				{data:'childcategory_name'  ,name:'childcategory_name'},
				{data:'category_name',name:'category_name'},
				{data:'subcat_name',name:'subcategory_name'},
				{data:'action',name:'action',orderable:true, searchable:true},

			]
		});
	});

  $('body').on('click','.edit',function(){
      let childcat_id=$(this).data("id");
      $.get("childcategory/edit/"+childcat_id,function(data){
          
         $("#modal_body").html(data);

      });
    });
</script>

@endsection