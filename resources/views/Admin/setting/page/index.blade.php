@extends('layouts.admin')
@section('admin_content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">All Pages</h1>
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
              <a href="{{route('page_create')}}" class="btn btn-primary">+ Add New</a>
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
                  <h3 class="card-title">All Page list here</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                      <thead>
                      <tr>
                        <th>SI</th>
                        <th>Page Name</th>
                        <th>Page Title</th>
                        <th>Action</th>                        
                      </tr>
                      </thead>
                      <tbody>
                  
                      @foreach ($data as $key=>$row)
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$row->page_name}}</td>
                            <td>{{$row->page_title}}</td> 

                             <td>
                                <a href="{{route('page_edit',$row->id)}}" class="btn btn-info btn-sm"><i class="fas fa-edit"></i>
                                </a>
                              <a href="{{route('page_delete',$row->id)}}" id="delete"class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
 
{{--Category Edit--}} 
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('category_update')}}" method="POST">
      @csrf
      <div class="modal-body">          
          <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" class="form-control" id="e_category_name" name="category_name" required>
            <input type="hidden" class="form-control" id="e_category_id" name="id" required>
            <small id="emailHelp" class="form-text text-muted">This is your main category</small>
          </div>         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('body').on('click','.edit',function(){
      let cat_id=$(this).data("id");
      $.get("category/edit/"+cat_id,function(data){
          
          $('#e_category_name').val(data.category_name);
          $('#e_category_id').val(data.id);

      });
    });
</script>
@endsection