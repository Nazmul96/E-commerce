@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sub Category</h1>
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
              <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">+ Add New</button>
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
                  <h3 class="card-title">All sub-Categories list here</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Sub Category Name</th>
                        <th> Sub Category Slug</th>
                        <th>Category Name</th>
                        <th>Action</th>                        
                      </tr>
                      </thead>
                      <tbody>
                    @foreach ($data as $key=>$row)
                              
                      <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$row->subcat_name}}</td>
                        <td>{{$row->subcat_slug}}</td>
                        <td>{{$row->category_name}}</td>
                        <td> 
                            <a href="#" class="btn btn-info btn-sm edit" data-id="{{$row->id}}" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></a>
                            <a href="{{route('subcat_delete',$row->id)}}" id="delete"class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        </td>                     
                     </tr>
                    @endforeach  
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
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('subcategory_store')}}" method="POST">
      @csrf
      <div class="modal-body">
           
        <div class="form-group">
          <label for="category_name">Category Name</label>
          <select class="form-control" name="category_id" required>
            @foreach($category as $row)
               <option value="{{$row->id}}">{{$row->category_name}}</option>
            @endforeach             
          </select>
        </div> 
        
          <div class="form-group">
            <label for="subcategory_name">sub-category Name</label>
            <input type="text" class="form-control" name="subcategory_name" required>
            <small id="emailHelp" class="form-text text-muted">This is your main subcategory</small>
          </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>
</div> 
{{--Subcategory Edit--}} 
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
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
    $('body').on('click','.edit',function(){
      let subcat_id=$(this).data("id");
      $.get("subcategory/edit/"+subcat_id,function(data){
          
         $("#modal_body").html(data);

      });
    });
</script>
@endsection